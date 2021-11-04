<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Comment;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Comments extends Component
{
    use WithPagination;  // ใช้ Pagination
    use WithFileUploads; // ใช้ upload ภาพ

    // public $comments;

    public $photo;   // ตัวแปรภาพ
    public $iteration;  // ตัวแปร นับจำนวนไฟล์ภาพ
    public $newComment;
    

    // กำหนด rule เพื่อกำหนดรูปแบบที่กำหนด
    protected $rules = [
        'newComment' => 'required|min:5|max:25',
        'photo' => 'image|max:2048'
        
    ];

    protected $messages = [
        'newComment.required' => 'The attribute can not be empty.',
        'newComment.min' => 'The attribute must longer than: min charactor >5.',
        'newComment.max' => 'The attribute must less than: max charactor <25.',
        'photo.image' => 'The attribute must be image only',
        'photo.max' => 'This attribute musht less than max bytes size'
    ];
    
    // Initializing mount function
    public function mount() {
        // $initialComments = Comment::latest()->get(); 
        // $initialComments = Comment::latest()->paginate(3); 
        // $this->comments = $initialComments;
    }

    // Realtime validation
    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }
    
    public function addComment() {
        
        $this->validate();
        
        if($this->newComment == ""){
            return;
        }


        // array_unshift(
        //     $this->comments, [
        //     'body'=> $this->newComment,
        //     'created_at' =>Carbon::now()->diffForHumans(),
        //     'creator' => 'Wichai'        
        //     ]
        // );

        $createdComment = Comment::create(
            [
                'body' => $this->newComment,
                'user_id' => 1
            ]
        );

        // เช็คว่ามีเลือกไฟล์ภาพเข้ามาหรือไม่
        if($this->photo){
            // this->photo->store('photos');
            // $name = md($this->photo . microtime()). '.'. $this->photo->extension();
            // $this->photo->storeAs('photos',$name);
            $this->photo->store('images/comments','public');
        }

        // $this->comments->prepend($createdComment);  // ไม่ให้ error หลังใช้ paginate

        // Clear input field
        $this->newComment= "";
        $this->photo = null;
        $this->iteration++;

        // แสดงให้ผู้ใช้เห็น
        session()->flash('message_added','Comment successfully added');
    }  
    
    // ฟังก์ชันในการลบข้อมูล
    public function remove($commendId) {
        // dd('aa'.$commendId);
        
        // ทำการลบข้อมูลที่ส่ง $commendId มา
        $comment = Comment::find($commendId);
        $comment->delete();

        // ทำการ refresh เพื่อแสดงข้อมูล ให้ทำเฉพาะที่เราเลือก
        // $this->comments = $this->comments->except($commendId); // ไม่ให้ error หลังใช้ paginate

        // แสดงให้ผู้ใช้เห็น
        session()->flash('message_deleted','Comment successfully deleted');
    }



    public function render()
    {
        return view('livewire.comments', [
            'comments' => Comment::latest()->paginate(3)
        ]);
    }
}
