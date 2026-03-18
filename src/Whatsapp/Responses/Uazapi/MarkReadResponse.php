<?php 

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

class MarkReadResponse
{
    /**
     * How many messages were sucessfully read?
     *
     * @var integer
     */
    public readonly int $successful;

    /**
     * How many messages did fail reading?
     *
     * @var integer
     */
    public readonly int $failed;

    /**
     * Were all messages sucessful?
     *
     * @var boolean
     */
    public readonly bool $allSuccessful;

    /**
     * Result of the operation as array with more informations
     *
     * @var array ['message_id' => "1234", "status" => "error", "error" => "Message not found"]
     * 
     */
    public readonly array $results;

    public function __construct(array $results)
    {
        $successful = 0;
        $failed = 0;
        foreach($results as $result){
            if(($result['status'] ?? '') != "success"){
                $failed++;
            }else{
                $successful++;
            }
        }
        $this->successful = $successful;
        $this->failed = $failed;
        $this->allSuccessful = $this->failed < 1;
        $this->results = $results;
    }

}