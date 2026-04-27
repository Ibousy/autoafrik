<?php

namespace Database\Seeders;

use App\Models\StockItem;
use Illuminate\Database\Seeder;

class StockItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['reference' => 'HUB-4521-BR', 'name' => 'Plaquettes de frein Bosch (avant)',     'category' => 'freinage',      'quantity' => 148, 'min_quantity' => 20, 'unit_price' => 12500,  'supplier' => 'AutoParts SN'],
            ['reference' => 'DISC-AVT-320', 'name' => 'Disques de frein 320mm Toyota/Hyundai', 'category' => 'freinage',      'quantity' => 2,   'min_quantity' => 8,  'unit_price' => 28000,  'supplier' => 'Benna Motors'],
            ['reference' => 'DISC-ARR-280', 'name' => 'Disques de frein 280mm (arrière)',       'category' => 'freinage',      'quantity' => 14,  'min_quantity' => 6,  'unit_price' => 22000,  'supplier' => 'Benna Motors'],
            ['reference' => 'FILT-OIL-15W', 'name' => 'Filtre à huile 15W-40',                 'category' => 'moteur',        'quantity' => 8,   'min_quantity' => 15, 'unit_price' => 4200,   'supplier' => 'Total Sénégal'],
            ['reference' => 'FILT-AIR-UNI', 'name' => 'Filtre à air universel',                 'category' => 'moteur',        'quantity' => 34,  'min_quantity' => 10, 'unit_price' => 6500,   'supplier' => 'AutoParts SN'],
            ['reference' => 'HUILE-5W30-4L','name' => 'Huile moteur 5W-30 (4L)',               'category' => 'moteur',        'quantity' => 22,  'min_quantity' => 10, 'unit_price' => 14000,  'supplier' => 'Total Sénégal'],
            ['reference' => 'CLIM-COMP-DN', 'name' => 'Compresseur climatisation Denso',        'category' => 'climatisation', 'quantity' => 12,  'min_quantity' => 5,  'unit_price' => 95000,  'supplier' => 'Peugeot Direct'],
            ['reference' => 'CLIM-FILT-CAB','name' => 'Filtre habitacle / pollen',              'category' => 'climatisation', 'quantity' => 45,  'min_quantity' => 15, 'unit_price' => 8000,   'supplier' => 'AutoParts SN'],
            ['reference' => 'PNEU-205-55',  'name' => 'Pneu Michelin 205/55 R16',              'category' => 'pneumatiques',  'quantity' => 1,   'min_quantity' => 8,  'unit_price' => 45000,  'supplier' => 'Michelin SN'],
            ['reference' => 'PNEU-195-65',  'name' => 'Pneu Michelin 195/65 R15',              'category' => 'pneumatiques',  'quantity' => 12,  'min_quantity' => 8,  'unit_price' => 38000,  'supplier' => 'Michelin SN'],
            ['reference' => 'PNEU-225-60',  'name' => 'Pneu Bridgestone 225/60 R17',           'category' => 'pneumatiques',  'quantity' => 6,   'min_quantity' => 4,  'unit_price' => 55000,  'supplier' => 'Bridgestone SN'],
            ['reference' => 'BATT-60AH-VR', 'name' => 'Batterie Varta 60Ah 12V',               'category' => 'electrique',    'quantity' => 23,  'min_quantity' => 5,  'unit_price' => 68000,  'supplier' => 'Varta Afrique'],
            ['reference' => 'BATT-70AH-BR', 'name' => 'Batterie Bosch 70Ah 12V',               'category' => 'electrique',    'quantity' => 11,  'min_quantity' => 4,  'unit_price' => 78000,  'supplier' => 'AutoParts SN'],
            ['reference' => 'ALT-UNI-70A',  'name' => 'Alternateur universel 70A',              'category' => 'electrique',    'quantity' => 5,   'min_quantity' => 3,  'unit_price' => 85000,  'supplier' => 'Benna Motors'],
            ['reference' => 'EMBRG-SACHS',  'name' => 'Kit embrayage Sachs (VW/Peugeot)',       'category' => 'transmission',  'quantity' => 4,   'min_quantity' => 5,  'unit_price' => 120000, 'supplier' => 'Sachs Africa'],
            ['reference' => 'EMBRG-LUK-TY', 'name' => 'Kit embrayage LuK Toyota',              'category' => 'transmission',  'quantity' => 8,   'min_quantity' => 3,  'unit_price' => 135000, 'supplier' => 'AutoParts SN'],
            ['reference' => 'SUSP-AMO-AV',  'name' => 'Amortisseur avant universel',            'category' => 'carrosserie',   'quantity' => 16,  'min_quantity' => 4,  'unit_price' => 48000,  'supplier' => 'Monroe SN'],
            ['reference' => 'SUSP-RES-AV',  'name' => 'Ressort de suspension avant',            'category' => 'carrosserie',   'quantity' => 9,   'min_quantity' => 4,  'unit_price' => 32000,  'supplier' => 'Monroe SN'],
            ['reference' => 'ECHAP-CATALY', 'name' => 'Catalyseur universel',                   'category' => 'echappement',   'quantity' => 3,   'min_quantity' => 2,  'unit_price' => 95000,  'supplier' => 'AutoParts SN'],
            ['reference' => 'BGIE-COURT-R', 'name' => 'Bougie d\'allumage NGK (x4)',            'category' => 'moteur',        'quantity' => 60,  'min_quantity' => 20, 'unit_price' => 18000,  'supplier' => 'NGK Sénégal'],
        ];

        foreach ($items as $item) {
            StockItem::firstOrCreate(['reference' => $item['reference']], $item);
        }
    }
}
