<?php 

    if($data['category_id'] != $data['old_category_id'])
    {
        $old_category = $this->db->t1where('category', 'category_id=?', [
            $data['old_category_id']
        ]) ?: $this->return->code(404)->return('not_found', 'category')->get()->referer();

        $this->db->update('category', [
            'category_id' => $old_category->category_id,
            'category_count' => $old_category->category_count -= 1,
        ], ['id' => 'category_id']);

        $new_category = $this->db->t1where('category', 'category_id=?', [
            $data['category_id']
        ]) ?: $this->return->code(404)->return('not_found', 'category')->get()->referer();

        $this->db->update('category', [
            'category_id' => $new_category->category_id,
            'category_count' => $new_category->category_count += 1,
        ], ['id' => 'category_id']);
    }
