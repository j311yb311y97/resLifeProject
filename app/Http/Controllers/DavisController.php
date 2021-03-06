<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use App\Room;
use App\WhoAndWhere;
use App\Floor;

class DavisController extends Controller
{
     public function indexdavislower()
    {
		$floor = \DB::table('Floor')->where('FloorDescription', '=', 'Davis Lower Floor')->first();
		$rooms = \DB::table('Room')->where('FloorID', '=', $floor->FloorID)->get();
		return view('/davis/davislower', compact('rooms', 'floor'));
		
    }
	    public function indexdavisf2()
    {
		$floor = \DB::table('Floor')->where('FloorDescription', '=', 'Davis Second Floor')->first();
		$rooms = \DB::table('Room')->where('FloorID', '=', $floor->FloorID)->get();
		return view('/davis/davisf2', compact('rooms', 'floor'));
		
    }
	    public function indexdavisf3()
    {
		$floor = \DB::table('Floor')->where('FloorDescription', '=', 'Davis Third Floor')->first();
		$rooms = \DB::table('Room')->where('FloorID', '=', $floor->FloorID)->get();
		return view('/davis/davisf3', compact('rooms', 'floor'));
		
    }
	    public function indexdavisf4()
    {
		$floor = \DB::table('Floor')->where('FloorDescription', '=', 'Davis Fourth Floor')->first();
		$rooms = \DB::table('Room')->where('FloorID', '=', $floor->FloorID)->get();
		return view('/davis/davisf3', compact('rooms', 'floor'));
		
    }
	public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$student = Users::find(auth()->id());
		$room = Room::find($request->get('id'));
		$whos = $year = \DB::table('WhoAndWhere')->where('StudentID', '=', $student->StudentID)->first();
		if($whos == null){
        $who = new WhoAndWhere([
		'StudentID' => $student->StudentID,
		'BuildingID' => $room->BuildingID,
		'FloorID' => $room->FloorID,
		'RoomID' => $room->RoomID,
		'YearOfResidenceID' => $room->YearOfResidenceID
		]);
		$who->timestamps = false;
		$room->timestamps = false;
        $who->save();
		$room->AmountTaken = $room->AmountTaken += 1;
		if($room->Capacity == $room->AmountTaken)
			$room->IsAvailable = 0;
		$room->save();
		return redirect('/almost')->with('success', 'You have choosen a room');
		}
		else{
			return redirect('/almost')->with('Hey', 'You have already choosen a room');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $who = WhoAndWhere::find($id);
		$who->delete();
		$room->timestamps = false;
		$room->AmountTaken = $room->AmountTaken -= 1;
		if($room->Capacity > $room->AmountTaken)
			$room->IsAvailable = 1;
		$room->save();
		return redirect('/reshall')->with('success', 'you can pick another room');
    }
}
