import fs from 'node:fs';
import path from 'node:path';

const rootDir = process.cwd();
const failures = [];
const packagePath = path.join(rootDir, 'package.json');
const scriptPath = path.join(rootDir, 'scripts', 'build-source-zip.mjs');

if (!fs.existsSync(packagePath) || !fs.statSync(packagePath).isFile()) {
  failures.push('package.json is missing.');
}

if (!fs.existsSync(scriptPath) || !fs.statSync(scriptPath).isFile()) {
  failures.push('scripts/build-source-zip.mjs is missing.');
}

let packageJson = {};
try {
  packageJson = JSON.parse(fs.readFileSync(packagePath, 'utf8'));
} catch (error) {
  failures.push(`Unable to parse package.json: ${error.message}`);
}

if (packageJson.scripts?.['build:zip'] !== 'node scripts/build-source-zip.mjs') {
  failures.push('npm run build:zip is not mapped to scripts/build-source-zip.mjs.');
}

if (fs.existsSync(scriptPath) && fs.statSync(scriptPath).isFile()) {
  const source = fs.readFileSync(scriptPath, 'utf8');
  for (const required of ['one-latest.zip', 'one-core-latest.zip', 'SOURCE-HANDOFF.json', "'release'", "'node_modules'", "'temp'", "os.tmpdir()", "'one-source-handoff'"]) {
    if (!source.includes(required)) {
      failures.push(`Source ZIP builder is missing required contract: ${required}`);
    }
  }

  if (source.includes("path.join(rootDir, 'temp')")) {
    failures.push('Source ZIP output must not be written inside the project tree.');
  }
}

if (failures.length > 0) {
  process.stderr.write(`Source ZIP contract failed:\n- ${failures.join('\n- ')}\n`);
  process.exit(1);
}

process.stdout.write('Source ZIP contract: PASS\n');
