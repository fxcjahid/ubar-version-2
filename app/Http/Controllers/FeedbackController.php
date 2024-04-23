<?php

namespace App\Http\Controllers;

use App\Models\DriverFeedBack;
use App\Models\Feedback;
use App\Models\UserFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    private $responce = ['status' => 200, "messeng" => "ok"];
    private function response(string $messeng = "ok", int $status = 200)
    {
        $this->responce['status'] = $status;
        $this->responce['messeng'] = $messeng;
        return response()->json($this->responce, $status);
    }
    public function index($id = null)
    {
        if (empty($id)) {
            $datas = Feedback::all();
            if ($datas->count() > 0) {
                return $this->response($datas);
            } else {
                return $this->response("Data not found");
            }
        } else {
            $datas = Feedback::get()->find($id);
            if ($datas) {
                return $this->response($datas->first());
            } else {
                return $this->response("Invalid id");
            }
        }
    }
    public function store(Request $request)
    {
        $valid =  Validator::make($request->all(), [
            'sender' => 'required',
            'reciver' => 'required',
            'comment' => 'required',
            'rating' => 'required',
        ]);
        if ($valid->fails()) {
            return $this->response($valid->messages(), 400);
        } else {
            $sender  = $request->input("sender");
            $reciver = $request->input("reciver");
            $comment = $request->input("comment");
            $rating  = $request->input("rating");
            $notifaction = 1; //active=1 deactive=0;
            $resuld = Feedback::create([
                'comment'     => $comment,
                'sender_id'   => $sender,
                'reciver_id'  => $reciver,
                'ratting'     => $rating,
                'notifaction' => $notifaction
            ]);
            if ($resuld) {
                return $this->response('Successfull');
            } else {
                return $this->response('Check Information', 400);
            }
        }
    }
    public function edete($id)
    {
        $datas = Feedback::get()->find($id);
        if ($datas) {
            return $this->response($datas->first());
        } else {
            return $this->response("Invalid id");
        }
    }
    public function update(Request $request, $id = null)
    {
        $feedback = Feedback::get()->find($id);
        if (!empty($feedback)) {
            $comment = $request->input("comment");
            $rating  = $request->input("rating");
            $resuld = $feedback->update([
                'comment'     => $comment,
                'ratting'     => $rating
            ]);
            if ($resuld) {
                return $this->response('Successfull');
            } else {
                return $this->response('Check Information', 400);
            }
        } else {
            return $this->response("Invalid id");
        }
    }
    public function delete($id)
    {
        $datas = Feedback::get()->find($id);
        if ($datas) {
            return $datas->delete() ? $this->response("Successfull") : $this->response("Check data", 400);
        } else {
            return $this->response("Invalid id");
        }
    }
    public function sender($sender, $id = null)
    {
        if (!empty($sender)) {
            $data = empty($id) ? Feedback::where("sender_id", $sender) : Feedback::where("sender_id", $sender)->where("id", $id);
            if ($data->get()->count() > 0) {
                return  $this->response($data->get(), 200);
            } else {
                return $this->response("Data not found", 400);
            }
        } else {
            return $this->response("Invalid sender id");
        }
    }
    public function reciver($reciver, $id = null)
    {
        if (!empty($reciver)) {
            $data = empty($id) ? Feedback::where("reciver_id", $reciver) : Feedback::where("reciver_id", $reciver)->where("id", $id);
            if ($data->get()->count() > 0) {
                return  $this->response($data->get(), 200);
            } else {
                return $this->response("Data not found", 400);
            }
        } else {
            return $this->response("Invalid reciver id");
        }
    }

    public function user_feedback()
    {
        $feedbacks = UserFeedback::latest()->get();
        return view('admin.feedback.user', compact('feedbacks'));
    }
    public function driver_feedback()
    {
        $feedbacks = DriverFeedBack::latest()->get();
        return view('admin.feedback.driver', compact('feedbacks'));
    }

    public function driver_store()
    {
        $feedbacks = DriverFeedBack::latest()->get();
        return view('admin.feedback.driver', compact('feedbacks'));
    }
}
