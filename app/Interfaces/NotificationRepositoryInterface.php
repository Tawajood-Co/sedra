<?php

namespace App\Interfaces;

interface NotificationRepositoryinterface
{
    public function create_device_token($type,$token,$id);
    public function delete_device_token($type,$token);

}
