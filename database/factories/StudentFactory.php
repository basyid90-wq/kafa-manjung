<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('ms_MY');
        
        // Random age between 7 and 12 for the year 2026
        $age = $faker->numberBetween(7, 12);
        $birthYear = 2026 - $age;
        $dob = $faker->dateTimeBetween("$birthYear-01-01", "$birthYear-12-31");
        $dobString = $dob->format('Y-m-d');
        
        // MyKid: YYMMDD08XXXX
        $yy = $dob->format('y');
        $mm = $dob->format('m');
        $dd = $dob->format('d');
        $myKid = $yy . $mm . $dd . '08' . $faker->unique()->numerify('####');
        
        $gender = $faker->randomElement(['L', 'P']);
        
        // Strictly Malay Naming Logic
        $maleNames = ['Ahmad', 'Muhammad', 'Mohd', 'Abdul', 'Khairul', 'Hafiz', 'Amirul', 'Zayyad', 'Ammar', 'Ridwan', 'Hassan', 'Anuar', 'Basri', 'Idris', 'Halim', 'Yusuf', 'Ismail'];
        $femaleNames = ['Nur', 'Siti', 'Nor', 'Aisha', 'Fatimah', 'Zahra', 'Imanina', 'Aminah', 'Salmah', 'Noraini', 'Iman', 'Alya', 'Zulaikha', 'Humaira'];
        
        $firstName = ($gender == 'L') ? $faker->randomElement($maleNames) : $faker->randomElement($femaleNames);
        // 70% chance of double first name like "Ahmad Zayyad"
        if ($faker->boolean(70)) {
            $firstName .= ' ' . (($gender == 'L') ? $faker->randomElement($maleNames) : $faker->randomElement($femaleNames));
        }
        $fatherNameForStudent = $faker->randomElement($maleNames) . ' ' . $faker->randomElement(['bin', 'bin', 'bin', 'binti']) . ' ' . $faker->randomElement($maleNames); // Simplified father name bit
        // Actually, more realistic:
        $fatherNameForStudent = $faker->randomElement($maleNames) . ' bin ' . $faker->randomElement($maleNames);
        
        $fullName = $firstName . (($gender == 'L') ? ' bin ' : ' binti ') . $faker->randomElement($maleNames);

        $manjungLocations = [
            'Hospital Manjung', 'Seri Manjung', 'Sitiawan', 'Lumut', 
            'Pangkor', 'Ayer Tawar', 'Kg. Acheh', 'Teluk Batik'
        ];
        $birthPlace = $faker->randomElement($manjungLocations) . ', Perak';
        
        $skSchools = [
            'SK Seri Manjung', 'SK Lumut', 'SK Methodist (ACS) Sitiawan',
            'SK Pangkor', 'SK Ayer Tawar', 'SK Simpang Empat', 'SK Kayan'
        ];
        
        $addressTemplates = [
            'No {num}, Jalan Venice {num}, Desa Venice, 32040 Seri Manjung, Perak.',
            'No {num}, Jalan Prima {num}, Taman Prima Jaya, 32040 Seri Manjung, Perak.',
            'Lot {num}, Kampung Tersusun, 32200 Lumut, Perak.',
            'No {num}, Taman Sitiawan Rezidensi, 32000 Sitiawan, Perak.',
            'No {num}, Jalan Pantai {num}, 32200 Lumut, Perak.'
        ];
        $address = str_replace('{num}', $faker->numberBetween(1, 150), $faker->randomElement($addressTemplates));

        // Logic for Parents
        $fName = $faker->randomElement($maleNames) . ' bin ' . $faker->randomElement($maleNames);
        $mName = $faker->randomElement($femaleNames) . ' binti ' . $faker->randomElement($maleNames);
        $fPhone = '01' . $faker->numerify('#-#######');
        $mPhone = '01' . $faker->numerify('#-#######');
        $fJob = $faker->randomElement(['Juruteknik', 'Peniaga', 'Penjawat Awam', 'Buruh', 'Penyelia', 'Pemandu']);
        $mJob = $faker->randomElement(['Guru', 'Kerani', 'Suri Rumah', 'Jururawat', 'Peniaga', 'Suri Rumah']);

        return [
            'school_id' => \App\Models\School::factory(),
            'kafa_class_id' => \App\Models\KafaClass::factory(),
            'parent_id' => \App\Models\User::factory(),
            'name' => $fullName,
            'mykid' => $myKid,
            'gender' => $gender,
            'dob' => $dobString,
            'age' => $age,
            'birth_place' => $birthPlace,
            'race' => 'Melayu',
            'citizenship' => 'Warganegara',
            'address' => $address,
            'oku_status' => 'Tiada',
            'registration_no' => 'KAFA/MNJ/2026/' . $faker->unique()->numerify('###'),
            'session_year' => '2026/2027',
            'status' => 'Aktif',
            'entry_date' => '2026-01-02',
            'origin_school' => $faker->randomElement($skSchools),
            'upkk_number' => ($age >= 11) ? 'UPKK202608' . $faker->unique()->numerify('###') : null,
            'father_name' => $fName,
            'father_ic' => $faker->numerify('############'),
            'father_phone' => $fPhone,
            'father_job' => $fJob,
            'father_income' => $faker->randomFloat(2, 2500, 8000),
            'mother_name' => $mName,
            'mother_ic' => $faker->numerify('############'),
            'mother_phone' => $mPhone,
            'mother_job' => $mJob,
            'mother_income' => ($mJob == 'Suri Rumah') ? 0 : $faker->randomFloat(2, 2000, 5000),
            'dependents_count' => $faker->numberBetween(1, 6),
            'parents_relationship_status' => 'Berkahwin',
            'chronic_disease' => $faker->randomElement(['Tiada', 'Tiada', 'Tiada', 'Asma Ringan']),
            'allergies' => $faker->randomElement(['Tiada', 'Tiada', 'Tiada', 'Seafood', 'Kacang']),
            'emergency_contact' => $fName . ' (' . $fPhone . ')',
        ];
    }
}
