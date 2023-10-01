<?php

namespace App\Console\Commands;

use App\Models\Assignment;
use App\Models\Organization;
use Illuminate\Console\Command;

class ImportOuiCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:oui-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import latest version of the IEEE OUI data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = public_path('oui1.csv');

        if (!file_exists($filename)) {
            $this->error('OUI CSV file not found'); return;
        }

        $file = fopen($filename, 'r');
        $header = fgetcsv($file); // header row

        // Read each row one by one after the header row
        while (($row = fgetcsv($file)) !== false) {
            // sanitize strings
            $organization_name = trim($row[2]);
            $organization_address = trim(preg_replace('/\s+/',' ', $row[3])); // remove excess spaces within the address string

            $organization = Organization::with('assignments')
                        ->where('name', $organization_name)
                        ->where('address', $organization_address)
                        ->first();
            
            // if organization doesn't exist already create both the organization and its assignment
            if (!$organization) {
                $this->info('Importing: ' . $organization_name);
                $organization = Organization::create([
                                    'name' => $organization_name,
                                    'address' => $organization_address,
                                ]);

                Assignment::create([
                    'organization_id' => $organization->id,
                    'registry' => trim($row[0]),
                    'assignment' => trim($row[1]),
                ]);
            } else {
                $registry = trim($row[0]);
                $oui = trim($row[1]);
                $assignment = $organization->assignments->where('assignment', $oui)->first();

                if ($assignment) {
                    // if both the organization and its assignment exist - update the assignment
                    $data = [
                        'organization_id' => $organization->id,
                        'registry' => $registry,
                        'assignment' => $oui,
                    ];
                    $assignment->update($data);
                } else {
                    // if organization exists and not its assignment - create its assignment
                    Assignment::create([
                        'organization_id' => $organization->id,
                        'registry' => $registry,
                        'assignment' => $oui,
                    ]);
                }
            }
        }

        fclose($file);

        $this->info('OUI data imported successfully!');
    }
}
