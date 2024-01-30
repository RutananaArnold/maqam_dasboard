<?php

namespace App\imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Agents;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class SingleSheetImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction(); // Start a database transaction

        try {
            $newlyAddedAgents = [];

            foreach ($rows->slice(1) as $row) {
                $agencyNumber = trim($row[1]);

                // Check if the agent_no needs a leading zero
                if (strlen($agencyNumber) < 8) {
                    $agencyNumber = str_pad($agencyNumber, 8, '0', STR_PAD_LEFT);
                }

                // Check if AGENCY_NUMBER already exists in the database
                $existingAgent = Agents::where('agent_no', $agencyNumber)->first();

                if ($existingAgent) {
                    // Update specific fields for the existing agent
                    $existingAgent->name = trim($row[2]);
                    $existingAgent->Email = trim($row[21]);
                    $existingAgent->mobile = trim($row[22]);
                    $existingAgent->IsActive = trim($row[17]) == 'Active' ? 1 : 0;
                    $existingAgent->Ismanager = (trim($row[4]) == 'Agent' || trim($row[4]) == 'Intern') ? 0 : 1;
                    $existingAgent->UnitNameDisplay = trim($row[8]);
                    $existingAgent->TeamNameDisplay = trim($row[5]);
                    $existingAgent->Role = trim($row[4]);
                    $existingAgent->AgencyNameDisplay = trim($row[11]);
                    $existingAgent->DirectorateNameDisplay = trim($row[14]);
                    $existingAgent->AADNameDisplay = trim($row[11]);
                    $existingAgent->hasLeadingZero = '1';
                    $existingAgent->TeamLeaderPhone = trim($row[23]);
                    $existingAgent->save();
                } else {
                    $newlyAddedAgents[] = $this->createNewAgent($row);
                }
            }

            // Use batch insertion for new records
            $this->batchInsertNewAgents($newlyAddedAgents);

            DB::commit(); // Commit the transaction when all operations are successful
            // Create a session to store the counts
            session([
                'newly_added_count' => count($newlyAddedAgents),
            ]);
        } catch (Exception $e) {
            DB::rollBack(); // Rollback the transaction in case of an error
            // Handle the exception
            dd($e->getMessage()); // or use any other way to handle the exception
        }
    }


    private function createNewAgent($row)
    {
        $agentNo = trim($row[1]);

        // Check if the agent_no needs a leading zero
        if (strlen($agentNo) < 8) {
            $agentNo = str_pad($agentNo, 8, '0', STR_PAD_LEFT);
        }

        return [
            'agent_no' => $agentNo,
            'name' => trim($row[2]),
            'Email' => trim($row[21]),
            'mobile' => trim($row[22]),
            'IsActive' => trim($row[17]) == 'Active' ? 1 : 0,
            'appointed_on' => now(),
            'Ismanager' => (trim($row[4]) == 'Agent' || trim($row[4]) == 'Intern') ? 0 : 1,
            'AttathmentCode' => 0,
            'BranchCode' => 0,
            'BranchNameDisplay' => '0',
            'UnitUnderBranchCode' => '0',
            'UnitUnderBranchManager' => '0',
            'UnitCode' => '0',
            'UnitNameDisplay' => trim($row[8]),
            'TeamCode' => 0,
            'TeamNameDisplay' => trim($row[5]),
            'PreviousUnitName' => '0',
            'PreviousUnitNameDESC' => '0',
            'PreviousTeamName' => '0',
            'PreviousTeamNameDESC' => '0',
            'Password' => '0',
            'Role' => trim($row[4]),
            'accept_leads' => 1,
            'profile_pic' => '0',
            'rank' => 0,
            'AgencyNameDisplay' => trim($row[11]),
            'DirectorateNameDisplay' => trim($row[14]),
            'AADNameDisplay' => trim($row[11]),
            'TeamLeaderPhone' => trim($row[23]),
            'Gender' => '0',
            'token' => '0',
            'AgentType' => 'Life',
            'hasLeadingZero' => '1',

        ];
    }

    private function batchInsertNewAgents($newlyAddedAgents)
    {
        $chunkSize = 1000; // Adjust the batch size as needed
        foreach (array_chunk($newlyAddedAgents, $chunkSize) as $chunk) {
            DB::table('agents_info')->insert($chunk);
        }
    }
}
