<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Todo;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class TodoController extends Controller {

    use HttpResponses;

    public function showPage() {
        return view( 'Frontend.pages.dashboard.todo' );
    }

    public function finishedPage() {
        return view( 'Frontend.pages.dashboard.finishedPage' );
    }

    public function CreateToDo( Request $request ) {
        // return $request;

        try {

            $user_id = $request->header( 'id' );
            if ( is_null( $request->input( 'description' ) ) ) {

                $data = Todo::create(
                    [
                        'user_id'     => $user_id,
                        'title'       => $request->input( 'title' ),
                        'exp_date'    => $request->exp_date,
                        'exp_time'    => $request->exp_time,
                        'description' => null,
                        'completed'   => 0,
                    ]
                );

            } else {

                $data = Todo::create(
                    [

                        'user_id'     => $user_id,
                        'title'       => $request->input( 'title' ),
                        'exp_date'    => $request->exp_date,
                        'exp_time'    => $request->exp_time,
                        'description' => $request->input( 'description' ),
                        'completed'   => 0,

                    ]
                );
            }

            return $this->success( $data, 'Successfully Added ToDo', '200' );

        } catch ( Exception $e ) {
            return $this->error( $e, 'Something Went Wrong', '200' );
        }

    }

    // Show Uncomplete Todo
    public function TodoList( Request $request ) {

        $user_id = $request->header( 'id' );

        $data = Todo::with( 'user' )
            ->where( 'user_id', '=', $user_id )
            ->where( 'completed', '=', '0' )
            ->get();

        if ( $data->count() == 0 ) {
            return $this->error( 'No Data', 'No Data Found', '200' );
        } else {
            return $this->success( $data, 'Success', '200' );
        }

    }

    // Show Uncomplete Todo
    public function limitedTodo( Request $request ) {

        $user_id = $request->header( 'id' );

        $data = Todo::with( 'user' )
            ->whereDate( 'exp_date', Carbon::today() )
            ->where( 'user_id', '=', $user_id )
            ->where( 'completed', '=', '0' )
            ->limit( 5 )
            ->get();

        if ( $data->count() == 0 ) {
            return $this->error( 'No Data', 'No Data Foundfdgdfgdfg', '200' );
        } else {
            return $this->success( $data, 'Success', '200' );
        }

    }

    // Show Complete Todo
    public function completeList( Request $request ) {

        $user_id = $request->header( 'id' );

        $data = Todo::with( 'user' )
            ->where( 'user_id', '=', $user_id )
            ->where( 'completed', '=', '1' )
            ->get();

        if ( $data->count() == 0 ) {
            return $this->error( 'No Data', 'No Data Foundfdgdfgdfg', '200' );
        } else {
            return $this->success( $data, 'Success', '200' );
        }

    }

    // // Update
    public function UpdateTodo( Request $request ) {

        $user_id = $request->header( 'id' );
        $todo = $request->input( 'id' );

        $data = Todo::where( 'id', '=', $todo )->where( 'user_id', '=', $user_id )->first();

        if ( $data->count() == 0 ) {

            return $this->error( 'No Data', 'No Data Found', '200' );

        } else {

            try {

                $data = $data->update( [
                    'title'       => $request->input( 'title' ),
                    'description' => $request->input( 'description' ),
                    'exp_date'    => $request->input( 'exp_date' ),
                    'exp_time'    => $request->input( 'exp_time' ),
                    'completed'   => $request->input( 'completed' ),
                ] );
                return $this->success( $data, 'Successfully Updated', '200' );
            } catch ( Exception $e ) {
                return $this->error( $e, 'Faild', '200' );
            }

        }

    }

    // Complete Method
    public function uncomplete( Request $request ) {
        $user_id = $request->header( 'id' );
        $id = $request->input( 'id' );

        $todo = Todo::where( 'id', '=', $id )
            ->where( 'user_id', '=', $user_id )
            ->first();

        if ( $todo->completed != 0 ) {
            return $this->error( "", "Todo Already Complete", "200" );
        } else {
            try {
                $todo->completed = 1;
                $todo->save();
                return $this->success( $request->completed, "Todo Is Finished", "200" );
            } catch ( Exception $e ) {
                return $this->success( $e, "Todo Is Finished", "200" );
            }
            // return $this->success( "", "Todo Is Finished", "200" );
        }

    }

    // // Delete
    public function DeleteTodo( Request $request ) {

        $user_id = $request->header( 'id' );
        $todo = $request->input( 'id' );

        $data = Todo::where( 'id', '=', $todo )->where( 'user_id', '=', $user_id );
        if ( $data->count() == 0 ) {
            return $this->error( '', 'Customer Not Found', '200' );
        } else {
            $data->delete();
            return $this->success( $data, 'Data Deleted Successfully', '200' );
        }

    }
}
