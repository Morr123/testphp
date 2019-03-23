<?php

namespace back\Models\DB\Providers;

interface ConnectorInterface{
	public function execute($sql, $binding = []);
}
