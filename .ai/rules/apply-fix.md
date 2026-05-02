# ⚙️ AI APPLY FIX RULES — CONTROLLED EXECUTION

> Location: `/cloudfold/.ai/rules/apply-fix.md`
> Goal: Apply refactor safely, file-by-file, zero regression

---

## 🚨 STRICT EXECUTION MODE

* ❌ DO NOT modify multiple files at once
* ❌ DO NOT delete before replacement
* ❌ DO NOT guess dependencies
* ✅ APPLY changes ONE FILE AT A TIME
* ✅ ALWAYS show diff output

---

## 🧭 INPUT REQUIREMENTS

AI must receive:

* Duplicate report (from full-scan.md)
* Refactor plan (from cleanup-rules.md)

If missing → STOP

---

## 🔁 EXECUTION FLOW (PER FILE)

1. Select ONE file
2. Identify duplicates inside that file
3. Replace usages with shared helper/service
4. Validate references/imports
5. THEN remove redundant code
6. Return diff

---

## 🔧 REPLACEMENT RULES

* Prefer extracting helpers into `/helpers`
* API logic → `/services`
* Hooks → `/hooks`
* UI → `/components`

---

## 🔗 DEPENDENCY VALIDATION

Before deleting anything:

Check:

* add_action / add_filter usage
* AJAX callbacks
* REST routes
* dynamic calls (string/function maps)

If ANY uncertainty:
→ DO NOT DELETE
→ mark REVIEW REQUIRED

---

## 🧪 POST-CHANGE CHECKLIST

After each file update:

* No undefined functions
* No missing imports/includes
* Hooks still registered
* AJAX endpoints reachable
* No JS console errors
* No PHP warnings/notices

---

## 📤 OUTPUT FORMAT (MANDATORY)

Use ONE of:

```diff
--- BEFORE
+++ AFTER
```

OR

```php
// FILE: path/to/file.php
```

---

## ⚠️ CRITICAL SAFE ZONES

NEVER modify:

* Freemius SDK
* License validation
* Security (nonce, sanitize, escape)
* DB schema/migrations
* Plugin bootstrap/init

---

## 🧠 ROLLBACK RULE

If any error detected after change:

* Revert current file changes
* Mark as REVIEW REQUIRED
* Explain risk

---

## 🚀 COMPLETION RULE

Repeat per file until all duplicates handled.

---

## 🔒 FAILURE MODE

If AI attempts bulk change:

Return:

```
VIOLATION: FILE-BY-FILE EXECUTION REQUIRED
```

---

## 🎯 GOAL

✔ Safe refactor
✔ No broken functionality
✔ Incremental verified changes

---

END
