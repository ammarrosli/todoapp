<?php

namespace App\Http\Controllers;
use App\Models\categoryModel;
use App\Models\listModel;
use App\Models\statusModel;
use App\Models\User;
use Illuminate\Http\Request;

class listController extends Controller
{  
  public function index(){
    return view('list');
  }

  public function store(Request $request){
    // dd($request->all());
    $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'deadline' => 'required|date',
      'completed' => 'nullable|boolean',
    ]);


    $listtodo = new listModel();

    $listtodo->title=$request -> title;
    $listtodo->description=$request -> description;
    $listtodo->deadline=$request -> deadline;
    $listtodo->completed = false;

      // Retrieve user, status, and category based on your logic
      $user = User::find($request->user_id); // Replace this with your logic to find the user
      $status = statusModel::find($request->status_id); // Replace this with your logic to find the status
      $category = categoryModel::find($request->category_id); // Replace this with your logic to find the category

      // Associate the retrieved user, status, and category with the list
      $listtodo->user()->associate($user);
      $listtodo->status()->associate($status);
      $listtodo->category()->associate($category);

      $listtodo->save();
      return redirect()->back()->with('success', 'New item added successfully')->with('hideMessageAfter', 1);

   }

   public function show(){

    $listtodo = listModel::all();
    return view('list', compact('listtodo'));
    }

    public function delete(Request $request, $id){
      listModel::destroy($id);
      return redirect()->back();
    }

    public function edit($id){
      $listtodo = listModel::find($id);
      return view('editlist')->with('listtodo', $listtodo);
  }


    public function update(Request $request, $id){
      // Validate the incoming request data
      $request->validate([
          'title' => 'required|string|max:255',
          // Add validation rules for other fields if needed
      ]);

      $listtodo = listModel::findOrFail($id);

    // Update the list item with the new data
      $listtodo->title = $request->title;
      $listtodo->description = $request->description;
      $listtodo->deadline = $request->deadline;
      
      // Check if the task is marked as completed
      // if ($request->has('completed') ? '1' : null ) {
      //     $listtodo->completed = true;
      // } else {
      //     $listtodo->completed = false;
      // }

      // Update the list item with the new data
      $listtodo->title = $request->title;
      $listtodo->description = $request->description;
      $listtodo->deadline = $request->deadline;
  
      // If you need to update associated models like user, status, and category,
      // you can retrieve them and update them similarly

      $completed = $request->has('completed')? '1' : null;
      $listtodo->completed=$completed;
  
      // Save the changes
      $listtodo->save();
  
      // Redirect back to the previous page
      return redirect('/listtodo')->with('success', 'List item updated successfully')->with('hideMessageAfter', 1);
  }
  

}