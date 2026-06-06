<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

class BulkMessageData
{
    public readonly string $id;
    public readonly string $info;
    public readonly string $status;
    public readonly int $scheduledFor;
    public readonly int $delayMax;
    public readonly int $delayMin;
    public readonly int $delivered;
    public readonly int $failed;
    public readonly int $played;
    public readonly int $read;
    public readonly int $success;
    public readonly int $total;
    public readonly string $owner;
    public readonly string $createdAt;
    public readonly string $updatedAt;

    /**
     * @param array{
     *  id: string,
     *  info: string,
     *  status: string,
     *  scheduled_for: int,
     *  delayMax: int,
     *  delayMin: int,
     *  log_delivered: int,
     *  log_failed: int,
     *  log_played: int,
     *  log_read: int,
     *  log_sucess: int,
     *  log_total: int,
     *  owner: string,
     *  created_at: string,
     *  updated_at: string
     * } $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->info = $data['info'];
        $this->status = $data['status'];
        $this->scheduledFor = $data['scheduled_for'];
        $this->delayMax = $data['delayMax'];
        $this->delayMin = $data['delayMin'];
        $this->delivered = $data['log_delivered'];
        $this->failed = $data['log_failed'];
        $this->played = $data['log_played'];
        $this->read = $data['log_read'];
        $this->success = $data['log_sucess'];
        $this->total = $data['log_total'];
        $this->owner = $data['owner'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
    }
}