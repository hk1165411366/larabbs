<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Handlers\ImageUploadHandler;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$topics = Topic::withOrder(request()->order)->paginate();
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic, Request $request)
    {
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }

        return view('topics.show', compact('topic' ));
    }

	public function create(Topic $topic)
	{
        $categories = Category::all();

		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
	    $topic->fill($request->all());
	    $topic->user_id = auth()->id();
	    $topic->save();

        return redirect()->to($topic->link())->with('success', '成功创建话题!');
	}

	public function edit(Topic $topic)
	{
        $categories = Category::all();
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('success', '修改成功.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '删除成功.');
	}

	public function uploadImage(ImageUploadHandler $upload, Request $request)
	{
		$data = [
			'success' => false,
			'msg' => '上传失败',
			'file_path' => ''
		];

		if ($file = $request->upload_file) {
			$result = $upload->save($file, 'TopicImage', 'topic', 1024);

			if ($result) {
                $data['success'] = true;
                $data['msg'] = '上传成功';
			    $data['file_path'] = $result['path'];
            }
		}

		return $data;
	}
}