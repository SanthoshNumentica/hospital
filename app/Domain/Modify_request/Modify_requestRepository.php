<?php
namespace Core\Domain\Modify_request;

use Core\Domain\DMLRepository;

interface Modify_requestRepository extends DMLRepository
{
	public function findAllByUserPagination($ftbl, $user_id);
}
