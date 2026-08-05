import fs from 'node:fs';
import path from 'node:path';
import { execFileSync } from 'node:child_process';

const rootDir = process.cwd();
const releaseRoot = path.join(rootDir, 'release');
const releaseDir = path.join(releaseRoot, 'one-core');
const zipPath = path.join(releaseRoot, 'one-core.zip');

function loadDistignoreRules() {
  const filePath = path.join(rootDir, '.distignore');
  try {
    const raw = fs.readFileSync(filePath, 'utf8');
    const lines = raw.split(/\r?\n/);
    const rules = [];
    for (const line of lines) {
      const s = line.trim();
      if (!s) continue;
      if (s.startsWith('#')) continue;
      if (/^\d+\./.test(s)) continue;
      if (/^[= -]{6,}$/.test(s)) continue;
      if (s.includes(' ')) continue;

      if (s.startsWith('.')) {
        rules.push({ type: 'suffix', value: s });
        continue;
      }

      const normalized = s.replaceAll('\\', '/').replace(/^\/+/, '');
      const isDir = normalized.endsWith('/');
      const pat = isDir ? normalized.slice(0, -1) : normalized;
      const hasSlash = pat.includes('/');
      const hasWildcard = pat.includes('*');

      if (!hasSlash && !hasWildcard) {
        rules.push({ type: 'name', value: pat });
        continue;
      }

      const escaped = pat.replace(/[.+^${}()|[\]\\]/g, '\\$&');
      const withWildcards = escaped.replaceAll('\\*\\*', '.*').replaceAll('\\*', '[^/]*');
      const source = hasSlash ? `^${withWildcards}${isDir ? '(/|$)' : '$'}` : `(^|/)${withWildcards}${isDir ? '(/|$)' : '$'}`;
      rules.push({ type: 'regex', value: new RegExp(source) });
    }
    return rules;
  } catch {
    return [];
  }
}

const distignoreRules = loadDistignoreRules();

function matchesDistignore(relPath) {
  const p = relPath.replaceAll('\\', '/');
  if (!p || p === '.') return false;
  for (const rule of distignoreRules) {
    if (rule.type === 'suffix') {
      if (p.endsWith(rule.value)) return true;
      continue;
    }
    if (rule.type === 'name') {
      if (p === rule.value || p.endsWith(`/${rule.value}`) || p.startsWith(`${rule.value}/`) || p.includes(`/${rule.value}/`)) {
        return true;
      }
      continue;
    }
    if (rule.type === 'regex') {
      if (rule.value.test(p)) return true;
    }
  }
  return false;
}

function rmrf(p) {
  try {
    fs.rmSync(p, { recursive: true, force: true });
  } catch {
    // ignore
  }
}

function ensureDir(p) {
  fs.mkdirSync(p, { recursive: true });
}

function readPluginVersion() {
  const pluginFile = path.join(rootDir, 'one-core.php');
  try {
    const src = fs.readFileSync(pluginFile, 'utf8');
    const m = src.match(/^\s*\*\s*Version:\s*([0-9]+(?:\.[0-9]+){0,3})\s*$/m);
    return m ? m[1] : null;
  } catch {
    return null;
  }
}

function shouldExclude(relPath) {
  const p = relPath.replaceAll('\\', '/');
  if (p === '' || p === '.') return false;

  const base = path.posix.basename(p);
  const excludedNames = new Set([
    'dist',
    'release',
    'scripts',
    'tests',
    '.ai',
    'node_modules',
    '.git',
    '.github',
    '.idea',
    '.vscode',
    '.DS_Store',
    '.distignore',
    '.gitignore',
    '.gitattributes',
    '.editorconfig',
    'AGENTS.md',
    'package.json',
    'package-lock.json',
    'SOURCE-HANDOFF.json',
    'release.mjs',
  ]);
  if (excludedNames.has(base)) return true;

  const excludedPrefixes = ['dist/', 'release/', 'scripts/', 'tests/', '.ai/', 'node_modules/', '.git/', '.github/', '.idea/', '.vscode/'];
  if (excludedPrefixes.some((prefix) => p.startsWith(prefix))) return true;
  if (base.endsWith('.log')) return true;
  if (base.endsWith('.map')) return true;
  if (base.toLowerCase().endsWith('.md')) return true;
  if (base === 'sass') return true;
  if (p.includes('/sass/')) return true;

  if (matchesDistignore(p)) return true;

  return false;
}

function copyTree(srcDir, destDir) {
  const entries = fs.readdirSync(srcDir, { withFileTypes: true });
  for (const entry of entries) {
    const srcPath = path.join(srcDir, entry.name);
    const relPath = path.relative(rootDir, srcPath);
    if (shouldExclude(relPath)) continue;

    const destPath = path.join(destDir, entry.name);
    if (entry.isDirectory()) {
      ensureDir(destPath);
      copyTree(srcPath, destPath);
      continue;
    }
    if (entry.isSymbolicLink()) {
      continue;
    }
    if (entry.isFile()) {
      ensureDir(path.dirname(destPath));
      fs.copyFileSync(srcPath, destPath);
    }
  }
}

function zipRelease() {
  execFileSync('zip', ['-r', zipPath, 'one-core'], {
    cwd: releaseRoot,
    stdio: 'inherit',
  });
}

rmrf(path.join(rootDir, 'dist'));
rmrf(releaseRoot);
ensureDir(releaseDir);
copyTree(rootDir, releaseDir);
zipRelease();

const version = readPluginVersion();
const label = version ? `v${version}` : 'v?';
process.stdout.write(`\nRelease ready: ${path.relative(rootDir, releaseDir)} (${label})\n`);
process.stdout.write(`ZIP ready: ${path.relative(rootDir, zipPath)}\n`);
