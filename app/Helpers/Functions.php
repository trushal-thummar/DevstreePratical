<?php

use Illuminate\Support\Facades\File;
use Carbon\Carbon;

function fileUpload($path, $file, $prefix = NULL) {
	$fileName = '';
	
	//Create Unique File Name
	$timestamp = Carbon::now()->timestamp;
	$fileName = \Str::random(10).'-'.$timestamp . '.' . strtolower($file->getClientOriginalExtension());
	$filePath = public_path($path);

	//Check Folder Is Exist Or Not
	if (is_dir($filePath) == false) {
		$directoryPath = public_path() . '/' . $path;

		//Create Directory
		File::makeDirectory($directoryPath, $mode = 0777, true, true);
	}

	//Move Uploaded File As Per Given Path
	$isUpload = $file->move(public_path() . '/' . $path, $fileName);
	
	return $fileName;
}