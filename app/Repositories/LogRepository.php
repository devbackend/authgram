<?php

namespace App\Repositories;

use App\Entities\Log;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Репозиторий логов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class LogRepository extends Repository {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function initEntity() {
		$this->entity = new Log();
	}

	/**
	 * Загрузка логов.
	 *
	 * @return LengthAwarePaginator
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function load() {
		return $this->entity
			->where('deleted_at', null)
			->orderBy(Log::INSERT_STAMP, 'desc')
			->paginate(50)
		;
	}

	/**
	 * Удаление логов
	 *
	 * @param string[] $guids
	 *
	 * @return int
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function deleteAll($guids) {
		$now = Carbon::now();

		return $this->db->table(Log::table())
			->whereIn(Log::GUID, $guids)
			->update([Log::DELETED_AT => $now])
		;
	}

	/**
	 * Удаление логов по вхождению подстроки.
	 *
	 * @param string $subString
	 *
	 * @return int
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function deleteByContent(string $subString) {
		$now = Carbon::now();

		$likeString = '%' . $subString . '%';

		return $this->db->table(Log::table())
			->where(Log::MESSAGE, 'ILIKE', $likeString)
			->orWhere(Log::CATEGORY, 'ILIKE', $likeString)
			->update([Log::DELETED_AT => $now])
		;
	}
}