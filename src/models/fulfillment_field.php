<?

class FulfillmentField extends Field
{
    private $fulfillment_id;

    public function __construct(int $field_id, int $fulfillment_id){
        parent::__construct($field_id);
        
        $this->fulfillment_id

    }
}