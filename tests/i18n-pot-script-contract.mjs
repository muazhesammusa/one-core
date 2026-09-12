import fs from 'node:fs';

const pkg = JSON.parse(fs.readFileSync(new URL('../package.json', import.meta.url), 'utf8'));
const expected = 'wp i18n make-pot . languages/one-core.pot --domain=ONE_CORE_SLUG --exclude=node_modules,release,vendor';
if (pkg.scripts?.['i18n:pot'] !== expected) {
  throw new Error('One Core i18n:pot script must preserve the current canonical ONE_CORE_SLUG domain.');
}
if (pkg.scripts?.prebuild !== 'npm run i18n:pot') {
  throw new Error('One Core prebuild must refresh the POT before release builds.');
}
console.log('One Core i18n POT script contract: PASS');
