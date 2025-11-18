<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Roles::class);
        $this->call(FirstUser::class);
        $this->call(Permissions::class);
        $this->call(PageTypes::class);
        $this->call(RolePage::class);
        $this->call(PermissionSuperAdmin::class);
        $this->call(ModulePage::class);
        $this->call(PagePage::class);
        // Crear módulos/páginas del área de administración del colegio antes de insertar datos que los consumen
        $this->call(SchoolAdminPageSeeder::class);
        $this->call(TopicsPageSeeder::class);
        $this->call(ActivitiesPageSeeder::class);
        $this->call(GradesPageSeeder::class);

        $this->call(EmployeesModuleSeeder::class);
        $this->call(GuardiansModuleSeeder::class);
        $this->call(StudentsModuleSeeder::class);

        $this->call(TopicsSeeder::class);
        $this->call(ActivitiesSeeder::class);

        // Seeders para datos de ejemplo
        $this->call(SampleStudentsSeeder::class);
        $this->call(SampleGradesSeeder::class);
        $this->call(EnrollmentTypeSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(EnrollmentSeeder::class);
    }
    
}
