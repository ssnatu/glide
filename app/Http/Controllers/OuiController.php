<?php

namespace App\Http\Controllers;

use App\Http\Requests\MacAddressRequest;
use App\Http\Requests\MacAddressMultipleRequest;
use App\Models\Assignment;
use Illuminate\Http\Request;

class OuiController extends Controller
{
    /**
     * Process single MAC address and returns vendor's OUI
     *
     * @param MacAddressRequest $request
     * @return JsonResponse
     */
    public function getOui(MacAddressRequest $request)
    {
        $mac_address = $this->filterMacAddress($request->mac_address); // remove all dashes, dots and colons

        // first three octets of Mac address are the OUI
        $oui = substr($mac_address, 0, 6);

        $assignment = Assignment::with('organization')->where('assignment', $oui)->first();

        if ($assignment) {
            return response()->json([
                'OUI' => $assignment->assignment,
                'Organization' => $assignment->organization->name,
            ], 200);
        } else {
            return response()->json([ 'error' => 'OUI could not be found'], 404);
        }
    }

    /**
     * Process multiple MAC addresses and returns vendor's OUI
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOuiMultiple(MacAddressMultipleRequest $request)
    {
        $mac_addresses = [];
        $response = [];

        if ($request->address_data) {
            foreach ($request->address_data as $data) {
                $mac_address = $this->filterMacAddress($data['mac_address']); // remove all dashes, dots and colons
                
                // push into $mac_addresses array
                array_push($mac_addresses, [
                    'mac_address' => $mac_address,
                    'vendor' => $data['vendor'],
                ]);
            }

            foreach ($mac_addresses as $key => $data) {
                $oui = substr($data['mac_address'], 0, 6);
    
                $assignment = Assignment::with('organization')->where('assignment', $oui)->first();

                $response[$key] = [
                    'OUI' => $assignment ? $assignment->assignment : 'OUI not found for mac_address ' . $data['mac_address'],
                    'Organization' => $assignment ? $assignment->organization->name : '',
                ];
            }
            if ($response) {
                return response()->json($response, 200);
            }
        } else {
            return response()->json();
        }
    }

    private function filterMacAddress($mac_address)
    {
        return str_ireplace(array( '-', ':', '.'), '', $mac_address);
    }
}
