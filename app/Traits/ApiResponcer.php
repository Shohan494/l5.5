<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponcer
{
		private function succesResponce($data, $code)
		{
				return response()->json($data, $code);
		}

		protected function errorResponce($message, $code)
		{
				return response()->json(['error' => $message, 'code' => $code], $code);
		}

		protected function showAll(Collection $collection, $code = 200)
		{
				return $this->succesResponce(['data' => $collection], $code);
		}

		protected function showOne(Model $model, $code = 200)
		{
				return $this->succesResponce(['data' => $model], $code);
		}

}
