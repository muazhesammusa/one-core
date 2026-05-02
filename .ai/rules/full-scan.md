# 🔍 AI FULL PROJECT SCAN RULES (SAFE MODE)

> Goal: Entire plugin scan করে duplicate detect করা (NO CODE CHANGE)

---

## 🚨 STRICT MODE

* ❌ NO code modification
* ❌ NO delete
* ❌ NO refactor
* ✅ ONLY detect + report

---

## 📂 SCAN SCOPE (FULL PROJECT)

AI must scan ALL files:

```
/ (root)
  ├── *.php
  ├── *.js / *.ts / *.tsx
  ├── *.css / *.scss
  ├── /includes
  ├── /admin
  ├── /public
  ├── /core
  ├── /helpers
  ├── /hooks
  ├── /modules
  ├── /services
  ├── /components
  ├── /assets
```

---

## 🔍 DETECTION TARGETS

### 1. Duplicate Functions

Detect:

* Same logic, different name
* Same name, multiple definitions

Output:

```
[FUNCTION DUPLICATE]
Name: function_name
Files:
 - path/file1.php:line
 - path/file2.php:line
Reason: identical logic / same purpose
Safe Merge: YES / REVIEW REQUIRED
Confidence: 100% / 80% / LOW
```

---

### 2. Duplicate Classes

Detect:

* Same responsibility classes
* Overlapping methods

Output:

```
[CLASS DUPLICATE]
Class: ClassName
Files:
 - path/file1.php
 - path/file2.php
Reason: similar methods / duplicated responsibility
Safe Merge: YES / REVIEW REQUIRED
Confidence: 100% / 80% / LOW
```

---

### 3. Repeated Logic Blocks

Detect:

* Same conditional logic
* Same calculation repeated

Output:

```
[LOGIC DUPLICATE]
Files:
 - path/file1.js:line
 - path/file2.js:line
Reason: repeated block
Suggestion: extract helper
Confidence: 100% / 80% / LOW
```

---

### 4. Repeated API Calls

Detect:

* Same endpoint used multiple places
* Same fetch/axios config duplicated

Output:

```
[API DUPLICATE]
Endpoint: /api/xyz
Files:
 - path/file1.js
 - path/file2.js
Suggestion: centralize service
Confidence: 100% / 80% / LOW
```

---

### 5. UI / Component Duplication

Detect:

* Same JSX/UI repeated
* Same markup blocks

Output:

```
[UI DUPLICATE]
Files:
 - component1.tsx
 - component2.tsx
Reason: identical UI structure
Suggestion: reusable component
Confidence: 100% / 80% / LOW
```

---

### 6. CSS / Tailwind Duplication

Detect:

* Same styles repeated
* Same utility groups repeated

Output:

```
[STYLE DUPLICATE]
Files:
 - style1.css
 - style2.css
Reason: repeated styling
Suggestion: shared class / utility
Confidence: 100% / 80% / LOW
```

---

### 7. WordPress Hook Duplication ⚠️

Detect:

* Duplicate add_action / add_filter
* Same hook registered multiple times

Output:

```
[HOOK DUPLICATE]
Hook: init
Files:
 - file1.php
 - file2.php
Risk: HIGH
Confidence: 100% / 80% / LOW
```

---

## 🔗 DEPENDENCY ANALYSIS (CRITICAL)

Before marking duplicate:

AI MUST check:

```
- Is function used in hooks?
- Is function used in AJAX?
- Is function used in REST?
- Is function dynamically called?
```

If unclear:

```
Safe Merge: REVIEW REQUIRED
```

---

## ⚠️ CRITICAL SAFE ZONES

AI must NOT flag these for removal:

* Freemius SDK
* License logic
* Security (nonce, sanitize)
* Database schema
* Bootstrap/init file

Mark as:

```
IGNORE (CORE SYSTEM)
```

---

## 🧠 CONFIDENCE SYSTEM

Each result MUST include:

```
Confidence: 100% / 80% / LOW
```

Rules:

* 100% → identical code
* 80% → very similar
* LOW → possible duplicate

---

## 📊 FINAL OUTPUT FORMAT

AI must return:

```
========================
🔍 DUPLICATE SCAN REPORT
========================

Total Issues: X

1. [FUNCTION DUPLICATE]
...

2. [CLASS DUPLICATE]
...

3. [LOGIC DUPLICATE]
...

...

SUMMARY:
- Safe to Refactor: X
- Needs Review: X
- High Risk: X
```

---

## 🚀 EXECUTION RULE

AI MUST:

1. Scan → analyze → group duplicates
2. NOT modify anything
3. NOT suggest code changes yet
4. ONLY produce structured report

---

## 🔒 FAILURE RULE

If AI tries to:

* modify code
* remove code

👉 STOP and return:

```
VIOLATION: SCAN MODE ONLY
```

---

## 🎯 GOAL

✔ 100% accurate duplicate detection
✔ zero risk
✔ full visibility before refactor

---

END OF FILE
