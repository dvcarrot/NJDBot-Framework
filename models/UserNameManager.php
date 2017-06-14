<?php
namespace models;
use app\Memory;

class UserNameManager
{
	public $user_id= null;
	public $user_name = null;

	/**
	  * Saves a username into a database
	  *
	  */
	public function save()
	{
		if (!$this->user_id || !$this->user_name)
		{
			return false;
		}

		if (\QB::table(Memory::$memoryTable)
						->where('user_id', $this->user_id)
						->update([
								'user_name' => $this->user_name,
								'wait_for_name' => 0,
							]))
		{
			return true;		
		}

		return false;
	}

	/**
	  * Sets a wait_for_name flag as true
	  *
	  */
	public function activateWaitForUserNameFlag()
	{
		if (!$this->user_id || !$this->user_name)
		{
			return false;
		}

		if (\QB::table(Memory::$memoryTable)
						->where('user_id', $this->user_id)
						->update([
								'wait_for_name' => 1,
							]))
		{
			return true;		
		}

		return false;
	}
}

