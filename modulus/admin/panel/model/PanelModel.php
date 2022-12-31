<?php 

namespace modulus\admin\panel\model;
use core\model;

class PanelModel extends model
{
	public function GuestCount()
	{
		return $this->db->t1count('guest', 'guest_id > 0', [])->count;
	}

	public function ArticleCount()
	{
		return $this->db->t1count('article', 'article_id > 0', [])->count;
	}

	public function SettingCount()
	{
		return $this->db->t1count('setting', 'setting_id > 0', [])->count;
	}

	public function SectionCount()
	{
		return $this->db->t1count('section', 'section_id > 0', [])->count;
	}

	public function CategoryCount()
	{
		return $this->db->t1count('category', 'category_id > 0', [])->count;
	}
}

