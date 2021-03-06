<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Users;
use App\Room;
use App\WhoAndWhere;
use App\Floor;

class CentennialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexcentf1()
    {
	
		$floor = \DB::table('Floor')->where('FloorDescription', '=', 'Centennial First Floor')->first();
		$rooms = \DB::table('Room')->where('FloorID', '=', $floor->FloorID)->get();
		return view('/centennial/centf1', compact('rooms', 'floor'));
		
    }
	    public function indexcentf2()
    {
		$floor = \DB::table('Floor')->where('FloorDescription', '=', 'Centennial Second Floor')->first();
		$rooms = \DB::table('Room')->where('FloorID', '=', $floor->FloorID)->get();
		return view('/centennial/centf2', compact('rooms', 'floor'));
		
    }
	    public function indexcentf3()
    {
		$floor = \DB::table('Floor')->where('FloorDescription', '=', 'Centennial Third Floor')->first();
		$rooms = \DB::table('Room')->where('FloorID', '=', $floor->FloorID)->get();
		return view('/centennial/centf3', compact('rooms', 'floor'));
		
    }
	    public function indexcentf4()
    {
		$floor = \DB::table('Floor')->where('FloorDescription', '=', 'Centennial Fourth Floor')->first();
		$rooms = \DB::table('Room')->where('FloorID', '=', $floor->FloorID)->get();
		return view('/centennial/centf4', compact('rooms', 'floor'));
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
