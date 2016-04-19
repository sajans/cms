<?php
class Controller_Admin_Article extends Controller_Base
{

	public function action_index()
	{
		$data['articles'] = Model_Article::find('all');
		$this->template->title = "Articles";
		$this->template->content = View::forge('admin/article/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('article');

		if ( ! $data['article'] = Model_Article::find($id))
		{
			Session::set_flash('error', 'Could not find article #'.$id);
			Response::redirect('article');
		}

		$this->template->title = "Article";
		$this->template->content = View::forge('admin/article/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Article::validate('create');

			if ($val->run())
			{
				$article = Model_Article::forge(array(
					'category_id' => Input::post('category_id'),
					'name' => Input::post('name'),
					'description' => Input::post('description'),
					'keywords' => Input::post('keywords'),
					'image' => Input::post('image'),
				));

				if ($article and $article->save())
				{
					Session::set_flash('success', 'Added article #'.$article->id.'.');

					Response::redirect('article');
				}

				else
				{
					Session::set_flash('error', 'Could not save article.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Articles";
		$this->template->content = View::forge('admin/article/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('article');

		if ( ! $article = Model_Article::find($id))
		{
			Session::set_flash('error', 'Could not find article #'.$id);
			Response::redirect('article');
		}

		$val = Model_Article::validate('edit');

		if ($val->run())
		{
			$article->category_id = Input::post('category_id');
			$article->name = Input::post('name');
			$article->description = Input::post('description');
			$article->keywords = Input::post('keywords');
			$article->image = Input::post('image');

			if ($article->save())
			{
				Session::set_flash('success', 'Updated article #' . $id);

				Response::redirect('article');
			}

			else
			{
				Session::set_flash('error', 'Could not update article #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$article->category_id = $val->validated('category_id');
				$article->name = $val->validated('name');
				$article->description = $val->validated('description');
				$article->keywords = $val->validated('keywords');
				$article->image = $val->validated('image');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('article', $article, false);
		}

		$this->template->title = "Articles";
		$this->template->content = View::forge('admin/article/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('article');

		if ($article = Model_Article::find($id))
		{
			$article->delete();

			Session::set_flash('success', 'Deleted article #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete article #'.$id);
		}

		Response::redirect('article');

	}

}
