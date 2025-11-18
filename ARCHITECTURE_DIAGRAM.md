# 🏗️ ARQUITECTURA DEL MÓDULO DE NOTAS - DIAGRAMA Y FLUJOS

## 📐 DIAGRAMA DE ARQUITECTURA

```
┌─────────────────────────────────────────────────────────────────┐
│                       WEB APPLICATION                            │
│                   (Laravel 10 - Blade)                           │
└──────────────────────┬──────────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│                    ROUTING LAYER                                 │
│                   routes/web.php                                 │
│                                                                  │
│  GET    /school/admin/grades           → index                  │
│  GET    /school/admin/grades/create    → create                 │
│  POST   /school/admin/grades           → store                  │
│  GET    /school/admin/grades/{id}      → show                   │
│  GET    /school/admin/grades/{id}/edit → edit                   │
│  PUT    /school/admin/grades/{id}      → update                 │
│  DELETE /school/admin/grades/{id}      → destroy                │
└──────────────────────┬──────────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│                    CONTROLLER LAYER                              │
│              GradeController (app/Http/Controllers/)             │
│                                                                  │
│  ┌─ index()   ─────► Query DB, Paginate, Return View           │
│  ├─ create()  ─────► Load students, subjects, periods           │
│  ├─ store()   ─────► Validate, Save to DB, Redirect            │
│  ├─ show()    ─────► Load related data, Return View            │
│  ├─ edit()    ─────► Pre-fill data, Return View                 │
│  ├─ update()  ─────► Validate, Update DB, Redirect             │
│  └─ destroy() ─────► Soft Delete, Redirect                      │
└──────────────────────┬──────────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│                     MODEL LAYER                                  │
│                  Grade.php (app/Models/)                         │
│                                                                  │
│  ┌──────────────────────────────────────────┐                   │
│  │ Attributes:                              │                   │
│  │ - id, student_id, subject               │                   │
│  │ - academic_period                        │                   │
│  │ - first_partial, second_partial         │                   │
│  │ - final_grade, notes, created_by        │                   │
│  │ - created_at, updated_at, deleted_at    │                   │
│  ├──────────────────────────────────────────┤                   │
│  │ Relationships:                           │                   │
│  │ - student() → Student model              │                   │
│  │ - creator() → User model                 │                   │
│  ├──────────────────────────────────────────┤                   │
│  │ Accessors:                               │                   │
│  │ - average_partial                        │                   │
│  │ - status                                 │                   │
│  └──────────────────────────────────────────┘                   │
└──────────────────────┬──────────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│                   DATABASE LAYER                                 │
│                   MySQL Database                                 │
│                                                                  │
│  ┌────────────────────────────────────┐                          │
│  │ Table: grades                      │                          │
│  ├────────────────────────────────────┤                          │
│  │ id (PK)                            │                          │
│  │ student_id (FK)   ──►  students    │                          │
│  │ subject                            │                          │
│  │ academic_period                    │                          │
│  │ first_partial                      │                          │
│  │ second_partial                     │                          │
│  │ final_grade                        │                          │
│  │ notes                              │                          │
│  │ created_by (FK)   ──►  users       │                          │
│  │ created_at, updated_at, deleted_at │                          │
│  └────────────────────────────────────┘                          │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔄 FLUJO DE DATOS - CREAR NOTA

```
┌────────────────────┐
│   USER ACCESS      │
│ /school/admin/     │
│    grades/create   │
└─────────┬──────────┘
          │
          ▼
┌────────────────────────────────────────┐
│  GradeController::create()             │
│  - Load students list                  │
│  - Load subjects list                  │
│  - Load academic periods               │
│  - Return view('school_admin.grades... │
└─────────┬────────────────────────────┬─┘
          │                            │
          ▼                            ▼
    [DB Query]              [View Render]
    SELECT FROM              _form.blade.php
    students                 create.blade.php
          │                            │
          └────────────────┬───────────┘
                          │
                          ▼
                  ┌──────────────────┐
                  │  HTML FORM PAGE  │
                  │  Display to User │
                  └────────┬─────────┘
                          │
                  User fills form &
                  clicks "Save Grade"
                          │
                          ▼
    ┌──────────────────────────────────┐
    │  GradeController::store()        │
    │  - Receive POST request          │
    │  - Validate inputs               │
    │  │  ├─ student_id required       │
    │  │  ├─ subject required          │
    │  │  ├─ academic_period required  │
    │  │  ├─ grades 0-5 range         │
    │  │  └─ notes optional            │
    │  - If valid:                     │
    │  │  ├─ Grade::create() ──►   DB  │
    │  │  └─ Redirect to index         │
    │  - If invalid:                   │
    │  │  └─ Return with errors        │
    └──────────────────────────────────┘
                  │
          If Valid│
          ┌───────▼────────┐
          │                │
          ▼                ▼
    [Database        [Success
     INSERT]         Message]
          │                │
          └────────┬───────┘
                   │
                   ▼
          ┌───────────────────┐
          │ Redirect to Index │
          │ with Success Msg  │
          └────────┬──────────┘
                   │
                   ▼
          ┌─────────────────────┐
          │ Display Index Page  │
          │ with New Grade      │
          └─────────────────────┘
```

---

## 🔄 FLUJO DE DATOS - EDITAR NOTA

```
┌──────────────────────┐
│   USER CLICKS EDIT   │
│  /school/admin/      │
│  grades/1/edit       │
└────────┬─────────────┘
         │
         ▼
┌────────────────────────────────────────┐
│  GradeController::edit()               │
│  - Get grade by ID: Grade::find()      │
│  - Load students list                  │
│  - Load subjects list                  │
│  - Load academic periods               │
│  - Pass to view                        │
└────────┬──────────────────┬────────────┘
         │                  │
         ▼                  ▼
    [DB Query]        [View Render]
    SELECT FROM       _form.blade.php
    grades WHERE      edit.blade.php
    id = 1            (with current values)
         │                  │
         └────────┬─────────┘
                  │
                  ▼
        ┌──────────────────────┐
        │  HTML FORM PAGE      │
        │  Pre-filled values   │
        │  Display to User     │
        └──────────┬───────────┘
                   │
          User edits fields &
          clicks "Save Grade"
                   │
                   ▼
    ┌──────────────────────────────────┐
    │  GradeController::update()       │
    │  - Get grade by ID               │
    │  - Validate new inputs           │
    │  - If valid:                     │
    │  │  ├─ $grade->update() ────► DB │
    │  │  └─ Redirect to index         │
    │  - If invalid:                   │
    │  │  └─ Return with errors        │
    └──────────────────────────────────┘
                   │
           If Valid│
         ┌─────────▼──────┐
         │                │
         ▼                ▼
    [Database        [Success
     UPDATE]         Message]
         │                │
         └────────┬───────┘
                  │
                  ▼
         ┌───────────────────┐
         │ Redirect to Index │
         │ with Success Msg  │
         └────────┬──────────┘
                  │
                  ▼
         ┌──────────────────────┐
         │ Display Index Page   │
         │ with Updated Grade   │
         └──────────────────────┘
```

---

## 🔄 FLUJO DE DATOS - ELIMINAR NOTA

```
┌─────────────────────────┐
│  USER CLICKS DELETE     │
│ /school/admin/grades/1  │
│ [DELETE method]         │
└────────┬────────────────┘
         │
         ▼
┌────────────────────────────────────────┐
│  GradeController::destroy()            │
│  - Get grade by ID                     │
│  - Call $grade->delete() (softdelete)  │
│  - Redirect to index                   │
└────────┬────────────────────────────────┘
         │
         ▼
    ┌──────────────────────┐
    │ Database UPDATE      │
    │ Set deleted_at = now │
    │ (Soft Delete)        │
    └────────┬─────────────┘
             │
             ▼
    ┌──────────────────────┐
    │ Success Message      │
    │ "Grade removed       │
    │  successfully"       │
    └────────┬─────────────┘
             │
             ▼
    ┌──────────────────────┐
    │ Redirect to Index    │
    │ Grade no longer      │
    │ visible in list      │
    └──────────────────────┘
```

---

## 📊 DIAGRAMA DE RELACIONES

```
┌──────────────────────────────────────────────────────────────┐
│                      DATABASE SCHEMA                          │
└──────────────────────────────────────────────────────────────┘

    ┌─────────────────────┐
    │    STUDENTS         │
    ├─────────────────────┤
    │ id (PK)             │◄─────────────────┐
    │ first_name          │                  │
    │ last_name           │                  │
    │ grade               │                  │
    │ birth_date          │                  │
    │ guardian_id (FK)    │                  │
    │ ...                 │                  │
    └─────────────────────┘                  │
                                             │
                                          1:N
                                             │
    ┌─────────────────────┐                  │
    │     GRADES          │                  │
    ├─────────────────────┤                  │
    │ id (PK)             │                  │
    │ student_id (FK)     ├──────────────────┘
    │ subject             │
    │ academic_period     │
    │ first_partial       │
    │ second_partial      │
    │ final_grade         │
    │ notes               │
    │ created_by (FK)     ├──────────┐
    │ created_at          │          │
    │ updated_at          │          │
    │ deleted_at          │          │
    └─────────────────────┘          │
                                     │
                                  1:N
                                     │
    ┌─────────────────────┐          │
    │      USERS          │          │
    ├─────────────────────┤          │
    │ id (PK)             │◄─────────┘
    │ first_name          │
    │ last_name           │
    │ email               │
    │ password            │
    │ ...                 │
    └─────────────────────┘
```

---

## 🎯 DIAGRAMA DE ESTADOS - CALIFICACIÓN

```
                    ┌─────────────────┐
                    │  Grade Created  │
                    │  final_grade=NULL
                    └────────┬────────┘
                             │
              ┌──────────────┴──────────────┐
              │                             │
              ▼                             ▼
    ┌──────────────────┐      ┌──────────────────┐
    │ Assign Parcials  │      │ Assign Final     │
    │ first_partial=X  │      │ final_grade=Y    │
    │ second_partial=Y │      │                  │
    └────────┬─────────┘      └────────┬─────────┘
             │                         │
             └──────────────┬──────────┘
                           │
                           ▼
                 ┌─────────────────────┐
                 │ Calculate Status    │
                 │ average_partial = ? │
                 │ status = ?          │
                 └────────┬────────────┘
                          │
         ┌────────────────┼────────────────┐
         │                │                │
         ▼                ▼                ▼
    final_grade      final_grade         final_grade
    >= 3.0            < 3.0              == NULL
         │                │                │
         ▼                ▼                ▼
    ┌─────────┐      ┌─────────┐      ┌─────────┐
    │ PASSED  │      │ FAILED  │      │PENDING  │
    │ ✅      │      │ ❌      │      │ ⏳      │
    │ (Green) │      │ (Red)   │      │(Yellow) │
    └─────────┘      └─────────┘      └─────────┘
```

---

## 🔐 DIAGRAMA DE SEGURIDAD

```
┌──────────────────────────────────────────┐
│        USER REQUEST                       │
│  /school/admin/grades                    │
└──────────────┬───────────────────────────┘
               │
               ▼
        ┌──────────────────┐
        │ Check Auth?      │
        │ (middleware)     │
        └────┬─────────┬───┘
             │         │
        YES  │         │  NO
             │         │
             ▼         ▼
        [Proceed]  [Redirect to
                    Login]
             │
             ▼
        ┌──────────────────┐
        │ Check Permissions│
        │ (page access)    │
        └────┬─────────┬───┘
             │         │
        YES  │         │  NO
             │         │
             ▼         ▼
        [Proceed]  [Error 403]
             │
             ▼
        ┌──────────────────────┐
        │ Process Request      │
        │ (Validate CSRF       │
        │  Validate inputs)    │
        └────┬──────────────┬──┘
             │              │
        VALID│            │ INVALID
             │            │
             ▼            ▼
        [Execute]   [Return Errors]
             │
             ▼
        [Return Success]
```

---

## 🔄 CICLO DE VIDA DE UN OBJETO GRADE

```
1. CREATE
   └─► Grade::create() 
       └─► Validates & Saves to DB
           └─► created_at = NOW()
               └─► Status = PENDING

2. READ
   └─► Grade::find()
       └─► Loads from DB
           └─► Hydrates relationships
               └─► Calculates accessors

3. UPDATE
   └─► Grade::update()
       └─► Validates new data
           └─► Updates DB
               └─► updated_at = NOW()

4. DELETE (Soft)
   └─► Grade::delete()
       └─► Sets deleted_at = NOW()
           └─► Data still in DB
               └─► Excluded from normal queries

5. RESTORE (if needed)
   └─► Grade::restore()
       └─► Sets deleted_at = NULL
           └─► Data visible again
```

---

## 📈 DIAGRAMA DE FLUJO DE VALIDACIÓN

```
┌─────────────────────────┐
│  FORM SUBMISSION        │
│  POST /grades           │
└────────┬────────────────┘
         │
         ▼
┌────────────────────────────────────────┐
│  Validator::make()                     │
├────────────────────────────────────────┤
│  'student_id'                          │
│  ├─ required (✓)                       │
│  └─ exists:students,id (✓)             │
├────────────────────────────────────────┤
│  'subject'                             │
│  ├─ required (✓)                       │
│  └─ max:255 (✓)                        │
├────────────────────────────────────────┤
│  'academic_period'                     │
│  ├─ required (✓)                       │
│  └─ max:50 (✓)                         │
├────────────────────────────────────────┤
│  'first_partial'                       │
│  ├─ nullable (✓)                       │
│  ├─ numeric (✓)                        │
│  ├─ min:0 (✓)                          │
│  └─ max:5 (✓)                          │
├────────────────────────────────────────┤
│  'second_partial'                      │
│  ├─ nullable (✓)                       │
│  ├─ numeric (✓)                        │
│  ├─ min:0 (✓)                          │
│  └─ max:5 (✓)                          │
├────────────────────────────────────────┤
│  'final_grade'                         │
│  ├─ nullable (✓)                       │
│  ├─ numeric (✓)                        │
│  ├─ min:0 (✓)                          │
│  └─ max:5 (✓)                          │
├────────────────────────────────────────┤
│  'notes'                               │
│  ├─ nullable (✓)                       │
│  └─ string (✓)                         │
└────┬──────────────┬────────────────────┘
     │              │
VALID│            │INVALID
     │            │
     ▼            ▼
[Process]  [Return with
 Data      Errors]
```

---

## 🏗️ CAPAS DE LA APLICACIÓN

```
┌─────────────────────────────────────────────────────────────┐
│                    PRESENTATION LAYER                        │
│                    (Blade Views)                             │
│  ┌───────────────────────────────────────────────────┐      │
│  │ index.blade.php                                   │      │
│  │ create.blade.php                                  │      │
│  │ edit.blade.php                                    │      │
│  │ show.blade.php                                    │      │
│  │ _form.blade.php                                   │      │
│  └───────────────────────────────────────────────────┘      │
└─────────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────────┐
│                  APPLICATION LAYER                          │
│                  (Controllers)                              │
│  ┌───────────────────────────────────────────────────┐      │
│  │ GradeController                                   │      │
│  │ - index()                                         │      │
│  │ - create()                                        │      │
│  │ - store()                                         │      │
│  │ - show()                                          │      │
│  │ - edit()                                          │      │
│  │ - update()                                        │      │
│  │ - destroy()                                       │      │
│  └───────────────────────────────────────────────────┘      │
└─────────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────────┐
│                    DOMAIN LAYER                              │
│                    (Models)                                 │
│  ┌───────────────────────────────────────────────────┐      │
│  │ Grade Model                                       │      │
│  │ - Relationships                                   │      │
│  │ - Accessors                                       │      │
│  │ - Business Logic                                  │      │
│  └───────────────────────────────────────────────────┘      │
└─────────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────────┐
│                   DATA ACCESS LAYER                          │
│                   (Query Builder/ORM)                        │
│  ┌───────────────────────────────────────────────────┐      │
│  │ Eloquent ORM                                      │      │
│  │ - save(), update(), delete()                      │      │
│  │ - find(), get(), paginate()                       │      │
│  └───────────────────────────────────────────────────┘      │
└─────────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────────┐
│                  PERSISTENCE LAYER                          │
│                  (Database)                                 │
│  ┌───────────────────────────────────────────────────┐      │
│  │ MySQL Database                                    │      │
│  │ - grades table                                    │      │
│  │ - Related tables (students, users)                │      │
│  └───────────────────────────────────────────────────┘      │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔗 INTERDEPENDENCIAS

```
Grade Model
    ├─→ Student Model
    │   └─→ Guardian Model
    │       └─→ GuardianContact Model
    │
    └─→ User Model
        └─→ Role Model
            └─→ Permission Model

Routes
    ├─→ GradeController
    │   ├─→ Grade Model
    │   ├─→ Student Model
    │   └─→ Request Validation
    │
    └─→ Middleware (auth, check.page.permissions)
```

---

**Diagram Created:** 15 de Noviembre de 2025  
**Version:** 1.0  
**Status:** ✅ Complete

