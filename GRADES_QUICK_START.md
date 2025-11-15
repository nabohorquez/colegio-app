# Student Grades Module - Quick Start Guide

## 🚀 Installation & Setup

### Step 1: Run the Migration
```bash
php artisan migrate
```

This will create the `grades` table with all necessary columns and indexes.

---

## 📍 Accessing the Module

### URL
```
http://yourapp.local/school/admin/grades
```

### From Dashboard
1. Go to School Administration
2. Click on "Student Grades" menu item (when added to sidebar)

---

## 🎯 Common Operations

### Assign a Grade to a Student
```
1. Click "Assign New Grade" button
2. Select Student
3. Select Subject
4. Select Academic Period
5. Enter Grades (optional: first partial, second partial, final)
6. Add Observations (optional)
7. Click "Save Grade"
```

### Edit an Existing Grade
```
1. Find the grade in the table
2. Click the Edit button (✏️ icon)
3. Modify the fields
4. Click "Save Grade"
```

### View Grade Details
```
1. Click on the student name or any row
2. View complete grade information
3. Click "Edit" to make changes
```

### Delete a Grade
```
1. Find the grade in the table
2. Click the Delete button (🗑️ icon)
3. Confirm deletion
```

---

## 📊 Database Queries (Useful)

### Get All Grades for a Student
```sql
SELECT * FROM grades WHERE student_id = 1;
```

### Get Grades by Subject and Period
```sql
SELECT * FROM grades WHERE subject = 'Mathematics' AND academic_period = '2025-I';
```

### Get Failed Students
```sql
SELECT DISTINCT s.* FROM grades g
JOIN students s ON g.student_id = s.id
WHERE g.final_grade < 3.0;
```

### Get Grade Statistics
```sql
SELECT 
    subject,
    academic_period,
    AVG(final_grade) as average,
    COUNT(*) as total_grades
FROM grades
WHERE final_grade IS NOT NULL
GROUP BY subject, academic_period;
```

---

## 🔧 Artisan Commands

### Create Sample Data (if needed)
```bash
# This would require creating a seeder first
php artisan db:seed GradeSeeder
```

### Roll Back Migration
```bash
php artisan migrate:rollback --step=1
```

### Reset Database Completely
```bash
php artisan migrate:refresh
```

---

## 📋 Form Validation Errors

| Error | Cause | Solution |
|-------|-------|----------|
| "Student is required" | No student selected | Select a student from dropdown |
| "Subject is required" | Subject field empty | Select or enter a subject |
| "Grade must be between 0 and 5" | Invalid grade value | Enter value between 0 and 5 |
| "The student does not exist" | Invalid student_id | Select from provided list |

---

## 💡 Tips & Best Practices

### 1. Grade Entry
- Always fill the Student, Subject, and Academic Period fields
- Partial grades are optional but recommended
- Enter final grade only when both partials are done

### 2. Observations
- Use observations to note:
  - Special circumstances
  - Student improvements
  - Areas for focus
  - Attendance notes

### 3. Data Organization
- Use consistent subject names
- Keep periods standardized (2025-I, 2025-II, etc.)
- Review grades before finalizing

### 4. Performance
- The system shows 15 grades per page
- Use search/filter if available
- Soft deletes preserve historical data

---

## 🔍 Status Indicators

### Display Meanings
```
PASSED   (Green)   - Final grade >= 3.0
FAILED   (Red)     - Final grade < 3.0
PENDING  (Yellow)  - Final grade not assigned
```

---

## 📱 Responsive Design

The module is fully responsive:
- ✅ Desktop view (full table)
- ✅ Tablet view (table scrolls)
- ✅ Mobile view (adapted layout)

---

## 🔐 User Permissions

- Only authenticated users can access
- Only school administrators can manage grades
- Grades include "created_by" tracking
- All modifications are timestamped

---

## 🐛 Troubleshooting

### Issue: "Page not found" when accessing grades
**Solution:** 
- Ensure you've run `php artisan migrate`
- Check that routes are loaded: `php artisan route:list | grep grades`

### Issue: Students dropdown is empty
**Solution:**
- Ensure students exist in the database
- Create a student first before assigning grades

### Issue: Cannot delete a grade
**Solution:**
- Check user permissions
- Ensure you're authenticated
- Soft deletes should work (grade is marked as deleted but recoverable)

### Issue: Form validation keeps failing
**Solution:**
- Check that all required fields are filled
- Verify grades are between 0 and 5
- Ensure student ID is valid

---

## 📊 Bulk Operations (Future)

The following could be added in future versions:
- Import grades from CSV
- Export grades to PDF/Excel
- Bulk edit grades
- Generate grade reports
- Grade statistics dashboard

---

## 🔗 Related Modules

- **Students Module** - Manage students
- **Activities Module** - Manage school activities
- **Users/Teachers Module** - Manage teachers who grade

---

## 📞 Support

For issues or questions:
1. Check `GRADES_MODULE.md` for detailed documentation
2. Review this quick start guide
3. Check the implementation summary

---

## 🎓 Educational Context

### Colombian Grade Scale (0-5)
- **0 - 2.9** = Fail (Desaprobado)
- **3.0 - 3.9** = Acceptable (Aceptable)
- **4.0 - 4.5** = Good (Bueno)
- **4.6 - 5.0** = Excellent (Excelente)

---

## ✅ Ready to Use!

The Student Grades Module is now fully implemented and ready for use.

**Last Updated:** November 15, 2025  
**Version:** 1.0

