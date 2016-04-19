<?php
class Controller_Admin_Date extends Controller_Base
{

	public function action_index()
	{
		$data['dates'] = Model_Date::find('all');
		$this->template->title = "Dates";
		$this->template->content = View::forge('admin/date/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('date');

		if ( ! $data['date'] = Model_Date::find($id))
		{
			Session::set_flash('error', 'Could not find date #'.$id);
			Response::redirect('date');
		}

		$this->template->title = "Date";
		$this->template->content = View::forge('admin/date/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Date::validate('create');

			if ($val->run())
			{
				$date = Model_Date::forge(array(
					'name' => Input::post('name'),
					'description' => Input::post('description'),
					'date' => Input::post('date'),
					'keywords' => Input::post('keywords'),
				));

				if ($date and $date->save())
				{
					Session::set_flash('success', 'Added date #'.$date->id.'.');

					Response::redirect('date');
				}

				else
				{
					Session::set_flash('error', 'Could not save date.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Dates";
		$this->template->content = View::forge('admin/date/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('date');

		if ( ! $date = Model_Date::find($id))
		{
			Session::set_flash('error', 'Could not find date #'.$id);
			Response::redirect('date');
		}

		$val = Model_Date::validate('edit');

		if ($val->run())
		{
			$date->name = Input::post('name');
			$date->description = Input::post('description');
			$date->date = Input::post('date');
			$date->keywords = Input::post('keywords');

			if ($date->save())
			{
				Session::set_flash('success', 'Updated date #' . $id);

				Response::redirect('date');
			}

			else
			{
				Session::set_flash('error', 'Could not update date #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$date->name = $val->validated('name');
				$date->description = $val->validated('description');
				$date->date = $val->validated('date');
				$date->keywords = $val->validated('keywords');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('date', $date, false);
		}

		$this->template->title = "Dates";
		$this->template->content = View::forge('admin/date/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('date');

		if ($date = Model_Date::find($id))
		{
			$date->delete();

			Session::set_flash('success', 'Deleted date #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete date #'.$id);
		}

		Response::redirect('date');

	}

}
