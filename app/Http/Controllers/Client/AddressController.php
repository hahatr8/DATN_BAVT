<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function createadd(string $id)
    {
        $user = User::query()->findOrFail($id);
        return view('client.address.add', compact('user'));
    }

    public function storeadd(Request $request, string $id)
    {
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');


            $user = User::query()->findOrFail($id);

            $user->addresses()->create([
                'user_id' => $id,
                'country' => $params['country'],
                'District' => $params['District'],
                'city' => $params['city'],
                'address' => $params['address'],
            ]);


<<<<<<< HEAD
            return redirect()->route('client.myaccount',$id);
=======
            return redirect()->route('client.myaccount', $id);
>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90
        }
    }
    public function edit(string $id)
    {
<<<<<<< HEAD
        $addresses =  Address::query()->findOrFail($id);
        return view('client.address.edit', compact( 'addresses'));
=======
        $addresses = Address::query()->findOrFail($id);
        return view('client.address.edit', compact('addresses'));
>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90
    }
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $address = Address::query()->findOrFail($id);
<<<<<<< HEAD
            
            $address->update($params);
            return redirect()->route('client.myaccount',$address->user_id);
        }
    }
=======

            $address->update($params);
            return redirect()->route('client.myaccount', $address->user_id);
        }
    }

>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90
}
