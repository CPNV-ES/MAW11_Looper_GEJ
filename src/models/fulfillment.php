<?

require_once MODEL_DIR . '/databases_connectors/databases_choose.php';

class Fulfillment
{
    private DatabasesAccess $database_access;
 	private int $id;

    public function __construct(int $id)
	{
		$this->id = $id;

		$this->database_access = (new DatabasesChoose())->getDatabase();

		if (!$this->database_access->doesFulfillmentExist($id)) {
			throw new Exception('Fulfillment Does Not Exist');
		}
	}

    public function getField()
    {
        return new Field($this->database_access->getFulfillmentField($this->id));
    }

	public function getBody()
	{
    	return $this->database_access->getFulfillmentBody($this->id);
	}
}