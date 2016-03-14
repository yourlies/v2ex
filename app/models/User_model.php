<?php
class User_model extends Kotori_Model
{
    public function getUserInfo($user_id)
    {
        $user_info = $this->db->select('user',
            array(
                'id', 'username',
            ),
            array(
                'id' => $user_id,
            )
        );
    }

    public function getUserRecord($user_id)
    {
        $user_record = $this->db->select('user_record',
            array(
                'favorite_node_count',
                'favorite_topic_count',
                'favorite_user_count',
            ),
            array(
                'user_id' => $user_id,
            )
        );
        return $user_record[0];
    }

    public function signin($user)
    {
        return $this->db->insert('user',
            $user
        );
    }
    public function createUserRecord($user_id)
    {
        return $this->db->insert('user_record',
            array('user_id' => $user_id)
        );
    }

    public function updateUserRecord($updateInfo, $uid)
    {
        return $this->db->update('user_record',
            $updateInfo,
            array('user_id' => $uid)
        );
    }

    public function getUserId($field, $value)
    {
        $user_id = $this->db->select('user',
            array('id'),
            array(
                $field => $value,
            )
        );
        return $user_id[0]['id'];
    }

    public function validateUser($field, $value)
    {
        return $this->db->has('user',
            array(
                $field => $value,
            )
        );
    }

    public function validatePass($username)
    {
        $auth_key = $this->db->select('user',
            array('password_hash', 'auth_key'),
            array('username' => $username)
        );
        return $auth_key[0];
    }

    public function validateUsername($username)
    {
        $event = 'legal';
        //用户名太长
        if (strlen($username) > 16) {
            $event = 'long';
        }
        //用户名不合法
        if (!ctype_alnum($username)) {
            $event = 'illegal';
        }
        //用户名存在
        if ($this->db->has('user',
            array(
                'username' => $username,
            )
        )) {
            $event = 'exist';
        }
        //未输入用户名
        if ($username == '') {
            $event = 'undefined';
        }
        return eventGenerate('username', $event, $username);
    }

    public function validateEmail($email)
    {
        $event = 'legal';
        //邮箱格式错误
        $pattern = '/^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/i';
        if (!preg_match($pattern, $email)) {
            $event = 'illegal';
        }
        //邮箱存在
        if ($this->db->has('user',
            array(
                'email' => $email,
            )
        )) {
            $event = 'exist';
        }
        //未输入邮箱
        if ($email == '') {
            $event = 'undefined';
        }
        return eventGenerate('email', $event, $email);
    }

    public function validateUserId($user_id)
    {
        $event = 'legal';
        //用户不存在
        if (!$this->db->has('user',
            array(
                'id' => $user_id,
            )
        )) {
            $event = 'undefined';
        }
        return eventGenerate('user', $event, $user_id);
    }
}
