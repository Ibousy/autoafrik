<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['first_name' => 'Fatou',    'last_name' => 'Diallo',   'email' => 'fatou.diallo@gmail.com',   'phone' => '+221 77 234 56 78', 'type' => 'particulier', 'address' => 'Almadies, Dakar'],
            ['first_name' => 'Mamadou',  'last_name' => 'Sow',      'email' => 'm.sow@gmail.com',           'phone' => '+221 76 345 67 89', 'type' => 'particulier', 'address' => 'Plateau, Dakar'],
            ['first_name' => 'Aissatou', 'last_name' => 'Ba',       'email' => 'a.ba@businesssn.com',       'phone' => '+221 78 456 78 90', 'type' => 'entreprise',  'company_name' => 'Ba & Associés SARL', 'address' => 'Point E, Dakar'],
            ['first_name' => 'Lamine',   'last_name' => 'Diop',     'email' => 'l.diop@yahoo.fr',           'phone' => '+221 70 567 89 01', 'type' => 'particulier', 'address' => 'Parcelles Assainies, Dakar'],
            ['first_name' => 'Marie',    'last_name' => 'Faye',     'email' => 'm.faye@gmail.com',          'phone' => '+221 77 678 90 12', 'type' => 'particulier', 'address' => 'Mermoz, Dakar'],
            ['first_name' => 'Oumar',    'last_name' => 'Thiam',    'email' => 'o.thiam@senservices.sn',    'phone' => '+221 76 789 01 23', 'type' => 'entreprise',  'company_name' => 'SenServices Group', 'address' => 'Zone Industrielle, Dakar'],
            ['first_name' => 'Rokhaya',  'last_name' => 'Ndiaye',   'email' => 'r.ndiaye@gmail.com',        'phone' => '+221 77 890 12 34', 'type' => 'particulier', 'address' => 'Liberté 6, Dakar'],
            ['first_name' => 'Cheikh',   'last_name' => 'Fall',     'email' => null,                        'phone' => '+221 78 901 23 45', 'type' => 'particulier', 'address' => 'Thiès'],
            ['first_name' => 'Ndéye',    'last_name' => 'Mbaye',    'email' => 'ndeye.mbaye@orange.sn',     'phone' => '+221 70 012 34 56', 'type' => 'particulier', 'address' => 'Guédiawaye, Dakar'],
            ['first_name' => 'Pape',     'last_name' => 'Gueye',    'email' => null,                        'phone' => '+221 77 123 45 67', 'type' => 'particulier', 'address' => 'Kaolack'],
            ['first_name' => 'Khadija',  'last_name' => 'Diallo',   'email' => 'k.diallo@gmail.com',        'phone' => '+221 76 234 56 78', 'type' => 'particulier', 'address' => 'Sacré-Cœur, Dakar'],
            ['first_name' => 'Ibrahim',  'last_name' => 'Kane',     'email' => 'i.kane@afrikbtp.sn',        'phone' => '+221 78 345 67 89', 'type' => 'entreprise',  'company_name' => 'AfrikBTP Construction', 'address' => 'Diamniadio'],
            ['first_name' => 'Sokhna',   'last_name' => 'Sy',       'email' => 's.sy@gmail.com',            'phone' => '+221 70 456 78 90', 'type' => 'particulier', 'address' => 'Fann, Dakar'],
            ['first_name' => 'Moussa',   'last_name' => 'Cissé',    'email' => null,                        'phone' => '+221 77 567 89 01', 'type' => 'particulier', 'address' => 'Saint-Louis'],
            ['first_name' => 'Aminata',  'last_name' => 'Touré',    'email' => 'aminata.t@gmail.com',       'phone' => '+221 76 678 90 12', 'type' => 'particulier', 'address' => 'Hann Mariste, Dakar'],
        ];

        foreach ($clients as $c) {
            Client::firstOrCreate(['phone' => $c['phone']], $c);
        }
    }
}
