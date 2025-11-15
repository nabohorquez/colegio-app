# Student Grades Module Documentation

## Overview
The **Student Grades Module** allows administrators to assign and manage student grades across different subjects and academic periods within the school administration system.

## Features

- ✅ **Assign Grades**: Assign grades to students for specific subjects and academic periods
- ✅ **Grade Entry**: Support for partial grades (1st partial, 2nd partial) and final grades
- ✅ **Automatic Calculations**: Calculate average partial grades and determine pass/fail status
- ✅ **Observations**: Add notes and observations about student performance
- ✅ **Grade Tracking**: Track who assigned the grade and when
- ✅ **CRUD Operations**: Full Create, Read, Update, Delete functionality
- ✅ **Pagination**: List with pagination support for better performance

## File Structure

```
app/
  ├── Models/
  │   └── Grade.php                    # Grade Model with relationships
  ├── Http/
  │   └── Controllers/
  │       └── GradeController.php      # Main controller for grades
  
database/
  └── migrations/
      └── 2025_11_15_000000_create_grades_table.php

resources/views/school_admin/grades/
  ├── index.blade.php                 # List all grades
  ├── create.blade.php                # Form to create new grade
  ├── edit.blade.php                  # Form to edit existing grade
  ├── show.blade.php                  # Display grade details
  └── _form.blade.php                 # Shared form component
```

## Database Schema

### grades table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| student_id | bigint | Foreign key to students table |
| subject | varchar(255) | Subject name |
| academic_period | varchar(50) | Period identifier (e.g., 2025-I) |
| first_partial | decimal(5,2) | First partial grade (0-5) |
| second_partial | decimal(5,2) | Second partial grade (0-5) |
| final_grade | decimal(5,2) | Final grade (0-5) |
| notes | text | Observations/comments |
| created_by | bigint | Foreign key to users table (who created) |
| created_at | timestamp | Record creation timestamp |
| updated_at | timestamp | Record update timestamp |
| deleted_at | timestamp | Soft delete timestamp |

## Routes

All routes are prefixed with `/school/admin/grades` and protected by authentication.

| Method | Route | Action | Description |
|--------|-------|--------|-------------|
| GET | / | index | List all grades |
| GET | /create | create | Show form to create new grade |
| POST | / | store | Store new grade |
| GET | /{grade} | show | Display grade details |
| GET | /{grade}/edit | edit | Show form to edit grade |
| PUT | /{grade} | update | Update existing grade |
| DELETE | /{grade} | destroy | Delete grade (soft delete) |

## Route Names

- `school.grades.index` - List grades
- `school.grades.create` - Create form
- `school.grades.store` - Store action
- `school.grades.show` - Show details
- `school.grades.edit` - Edit form
- `school.grades.update` - Update action
- `school.grades.destroy` - Delete action

## Models

### Grade Model

**Relationships:**
- `student()` - Belongs to Student (many-to-one)
- `creator()` - Belongs to User (many-to-one)

**Accessors:**
- `average_partial` - Calculates average of first and second partial grades
- `status` - Returns 'passed', 'failed', or 'pending' based on final_grade

**Attributes:**
- `fillable`: All assignable columns

## Controller Methods

### GradeController

**index()** - Display paginated list of grades (15 per page)
- Returns: view with grades collection

**create()** - Show form to create new grade
- Returns: view with form and available students/subjects/periods

**store()** - Save new grade to database
- Validates input (student, subject, period, grades 0-5)
- Associates with authenticated user (created_by)
- Redirects to index with success message

**show()** - Display grade details
- Returns: detailed view of single grade

**edit()** - Show form to edit existing grade
- Returns: view with pre-filled form

**update()** - Update existing grade
- Validates same rules as store
- Redirects to index with success message

**destroy()** - Delete (soft delete) grade
- Redirects to index with success message

## Form Fields

### Create/Edit Form

**Basic Information:**
- Student (required, select dropdown)
- Subject (required, select dropdown with predefined options)
- Academic Period (required, select dropdown)

**Grades Section:**
- 1st Partial Grade (optional, 0-5)
- 2nd Partial Grade (optional, 0-5)
- Final Grade (optional, 0-5)

**Additional:**
- Observations/Comments (optional, textarea)

## Subject Options

The system includes these predefined subjects:
- Mathematics
- Spanish Language
- English
- Natural Sciences
- Social Studies
- Physical Education
- Art
- Computer Science

Teachers can also enter custom subjects.

## Academic Periods

Predefined periods:
- 2025-I
- 2025-II
- 2026-I
- 2026-II

## Views

### index.blade.php
- Displays table with all grades
- Shows student name, subject, period, partial grades, final grade, status
- Status badges: Passed (green), Failed (red), Pending (yellow)
- Edit/Delete action buttons
- Pagination links

### create.blade.php
- Page title: "Assign New Grade to Student"
- Includes _form component
- Back button to index

### edit.blade.php
- Page title: "Edit Grade"
- Includes _form component with pre-filled data
- Back button to index

### show.blade.php
- Displays complete grade information
- Student information card (name, grade, email, birth date)
- Grade information card (subject, period, all grades)
- Status and average display
- Audit information (created by, dates)
- Edit/Back buttons

### _form.blade.php
- Reusable form component
- Includes CSRF protection
- Bootstrap form styling with error display
- Grade scale indicator (0-5)
- Submit and Cancel buttons

## Validation Rules

```php
'student_id' => 'required|exists:students,id',
'subject' => 'required|string|max:255',
'academic_period' => 'required|string|max:50',
'first_partial' => 'nullable|numeric|min:0|max:5',
'second_partial' => 'nullable|numeric|min:0|max:5',
'final_grade' => 'nullable|numeric|min:0|max:5',
'notes' => 'nullable|string',
```

## Success Messages

- Create: "Grade assigned successfully to the student."
- Update: "Grade updated successfully."
- Delete: "Grade removed successfully."

## Error Handling

- Form validation errors are displayed inline with Bootstrap styling
- Student must exist in database
- Grades must be between 0 and 5
- Soft deletes preserve data for audit purposes

## Status Calculation

**Automatic Status Determination:**
- final_grade >= 3.0 → **PASSED** (green badge)
- final_grade < 3.0 → **FAILED** (red badge)
- final_grade is null → **PENDING** (yellow badge)

## Average Partial Calculation

- If both partial grades are present: (first_partial + second_partial) / 2
- Otherwise: null

## Usage Examples

### Access the Module
```
URL: /school/admin/grades
Route name: school.grades.index
```

### Assign a New Grade
```
1. Navigate to /school/admin/grades
2. Click "Assign New Grade" button
3. Fill in the form with student, subject, period, and grades
4. Click "Save Grade"
```

### Edit a Grade
```
1. Navigate to /school/admin/grades
2. Click the edit button (pencil icon) for the desired grade
3. Modify the grade information
4. Click "Save Grade"
```

### View Grade Details
```
1. Navigate to /school/admin/grades
2. Click on the student name or status indicator
3. View complete grade information and history
```

### Delete a Grade
```
1. Navigate to /school/admin/grades
2. Click the delete button (trash icon) for the desired grade
3. Confirm deletion in the confirmation dialog
```

## Relationships with Other Modules

- **Students Module**: Each grade is linked to a student
- **Users Module**: Tracks which user (teacher/admin) created/modified the grade
- **Authentication**: Protected by Laravel authentication middleware

## Migration Commands

```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Refresh database
php artisan migrate:refresh
```

## Notes

- Grades use a 0-5 scale (common in Colombian education system)
- Soft deletes are enabled for data preservation
- Pagination is set to 15 items per page
- All timestamps are managed automatically by Laravel
- Created_by is automatically set to the authenticated user

---

**Module Version:** 1.0  
**Created:** November 15, 2025  
**Status:** Complete and Ready for Use
