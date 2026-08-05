import crypto from 'node:crypto';
import fs from 'node:fs';
import os from 'node:os';
import path from 'node:path';
import { execFileSync } from 'node:child_process';

const rootDir = process.cwd();
const outputDir = path.join(os.tmpdir(), 'one-source-handoff');

function fail(message) {
  process.stderr.write(`ERROR: ${message}\n`);
  process.exit(1);
}

function detectProject() {
  const themeMarker = path.join(rootDir, 'style.css');
  const coreMarker = path.join(rootDir, 'one-core.php');

  if (fs.existsSync(themeMarker) && fs.statSync(themeMarker).isFile()) {
    return {
      type: 'theme',
      slug: 'one',
      filename: 'one-latest.zip',
      marker: 'style.css',
      version: readHeaderVersion(themeMarker),
    };
  }

  if (fs.existsSync(coreMarker) && fs.statSync(coreMarker).isFile()) {
    return {
      type: 'plugin',
      slug: 'one-core',
      filename: 'one-core-latest.zip',
      marker: 'one-core.php',
      version: readHeaderVersion(coreMarker),
    };
  }

  fail('Run this command from the One theme or One Core project root.');
}

function readHeaderVersion(filePath) {
  try {
    const contents = fs.readFileSync(filePath, 'utf8');
    const match = contents.match(/^\s*(?:\/\*+|\*)?\s*Version:\s*([^\r\n*]+?)\s*(?:\*\/)?\s*$/mi);
    return match ? match[1].trim() : null;
  } catch {
    return null;
  }
}

function gitRevision() {
  try {
    return execFileSync('git', ['rev-parse', '--short=12', 'HEAD'], {
      cwd: rootDir,
      encoding: 'utf8',
      stdio: ['ignore', 'pipe', 'ignore'],
    }).trim() || null;
  } catch {
    return null;
  }
}

const excludedTopLevel = new Set([
  '.git',
  '.svn',
  '.hg',
  '.idea',
  '.vscode',
  '.cache',
  '.phpunit.cache',
  'coverage',
  'dist',
  'node_modules',
  'release',
  'temp',
  '__MACOSX',
]);

const excludedNames = new Set([
  '.DS_Store',
  'Thumbs.db',
  'desktop.ini',
]);

function shouldExclude(relativePath, entryName) {
  const normalized = relativePath.replaceAll('\\', '/');
  const segments = normalized.split('/').filter(Boolean);

  if (segments.length > 0 && excludedTopLevel.has(segments[0])) {
    return true;
  }

  if (segments.some((segment) => segment === '.git' || segment === '__MACOSX')) {
    return true;
  }

  if (excludedNames.has(entryName)) {
    return true;
  }

  const lower = entryName.toLowerCase();
  return lower.endsWith('.zip')
    || lower.endsWith('.log')
    || lower.endsWith('.tmp')
    || lower.endsWith('.swp')
    || lower.endsWith('~');
}

function copyTree(sourceDir, destinationDir, projectRoot) {
  const entries = fs.readdirSync(sourceDir, { withFileTypes: true });

  for (const entry of entries) {
    const sourcePath = path.join(sourceDir, entry.name);
    const relativePath = path.relative(projectRoot, sourcePath);

    if (shouldExclude(relativePath, entry.name)) {
      continue;
    }

    const destinationPath = path.join(destinationDir, entry.name);

    if (entry.isDirectory()) {
      fs.mkdirSync(destinationPath, { recursive: true });
      copyTree(sourcePath, destinationPath, projectRoot);
      continue;
    }

    if (entry.isFile()) {
      fs.mkdirSync(path.dirname(destinationPath), { recursive: true });
      fs.copyFileSync(sourcePath, destinationPath);
    }
  }
}

function listArchive(zipPath) {
  return execFileSync('unzip', ['-Z1', zipPath], {
    encoding: 'utf8',
    stdio: ['ignore', 'pipe', 'pipe'],
  }).split(/\r?\n/).filter(Boolean);
}

function validateArchive(entries, project) {
  const prefix = `${project.slug}/`;
  const forbiddenFragments = [
    '/.git/',
    '/node_modules/',
    '/release/',
    '/temp/',
    '/__MACOSX/',
  ];

  if (!entries.some((entry) => entry === `${prefix}${project.marker}`)) {
    fail(`Archive marker is missing: ${prefix}${project.marker}`);
  }

  const outsideRoot = entries.find((entry) => entry !== project.slug && !entry.startsWith(prefix));
  if (outsideRoot) {
    fail(`Archive contains a path outside ${prefix}: ${outsideRoot}`);
  }

  const forbidden = entries.find((entry) => forbiddenFragments.some((fragment) => `/${entry}`.includes(fragment)));
  if (forbidden) {
    fail(`Archive contains an excluded path: ${forbidden}`);
  }
}

function sha256(filePath) {
  const hash = crypto.createHash('sha256');
  hash.update(fs.readFileSync(filePath));
  return hash.digest('hex');
}

function revealOutputDirectory() {
  if (process.platform !== 'darwin' || process.env.ONE_SOURCE_ZIP_NO_OPEN === '1') {
    return;
  }

  try {
    execFileSync('open', [outputDir], { stdio: 'ignore' });
  } catch (error) {
    process.stderr.write(`Warning: unable to open output folder: ${error.message}\n`);
  }
}

const project = detectProject();
const stagingRoot = fs.mkdtempSync(path.join(os.tmpdir(), `${project.slug}-source-`));
const stagedProject = path.join(stagingRoot, project.slug);
const zipPath = path.join(outputDir, project.filename);
const checksumPath = `${zipPath}.sha256`;

try {
  fs.mkdirSync(outputDir, { recursive: true });
  fs.rmSync(zipPath, { force: true });
  fs.rmSync(checksumPath, { force: true });
  fs.mkdirSync(stagedProject, { recursive: true });

  copyTree(rootDir, stagedProject, rootDir);

  const metadata = {
    schema: 1,
    project: project.slug,
    artifact_type: project.type,
    version: project.version,
    git_revision: gitRevision(),
    generated_at: new Date().toISOString(),
    purpose: 'Source handoff for development and audit',
    excluded_top_level: [...excludedTopLevel].sort(),
    output_directory: outputDir,
  };

  fs.writeFileSync(
    path.join(stagedProject, 'SOURCE-HANDOFF.json'),
    `${JSON.stringify(metadata, null, 2)}\n`,
    'utf8',
  );

  execFileSync('zip', ['-rq', zipPath, project.slug], {
    cwd: stagingRoot,
    stdio: 'inherit',
  });

  execFileSync('unzip', ['-tq', zipPath], { stdio: 'inherit' });

  const entries = listArchive(zipPath);
  validateArchive(entries, project);

  const digest = sha256(zipPath);
  fs.writeFileSync(checksumPath, `${digest}  ${project.filename}\n`, 'utf8');

  process.stdout.write('\nSource handoff ready\n');
  process.stdout.write(`Project: ${project.slug}${project.version ? ` v${project.version}` : ''}\n`);
  process.stdout.write(`Files: ${entries.filter((entry) => !entry.endsWith('/')).length}\n`);
  process.stdout.write(`ZIP: ${zipPath}\n`);
  process.stdout.write(`SHA-256: ${checksumPath}\n`);
  revealOutputDirectory();
} finally {
  fs.rmSync(stagingRoot, { recursive: true, force: true });
}
