<?php
/*
 * change these to match your setup.
 */
$root = realpath(dirname(__FILE__) . '/../');

/*
 * Let the user know what is going on
 */
echo "Creating phar for GearmanWorker Nagios plugin located at " . $root . "\n";

/*
 * Clean up from previous
 */
if (file_exists('GearmanWorker.phar')) {
	Phar::unlinkArchive('GearmanWorker.phar');
}

/*
 * Setup the phar
 */
$phar = new Phar('GearmanWorker.phar', 0, 'GearmanWorker.phar');
$phar->compressFiles(Phar::GZ);
$phar->setSignatureAlgorithm(Phar::SHA1);

// start buffering. Mandatory to modify stub.
$phar->startBuffering();

// Get the default stub. You can create your own if you have specific needs
$defaultStub = $phar->createDefaultStub('scripts/GearmanWorker.php');

// Adding files
$phar->buildFromDirectory(realpath(__DIR__ . '/../'), '/\.php$/');

// Create a custom stub to add the shebang
$stub = "#!/usr/bin/php \n" . $defaultStub . "\n__HALT_COMPILER(); ";

// Add the stub
$phar->setStub($stub);

$phar->stopBuffering();
unset($phar);

// Make file executable
chmod('GearmanWorker.phar', 0755);

// /*
//  * Clean up from previous 
//  */
// if (file_exists('GearmanWorker.phar')) {
// 	Phar::unlinkArchive('GearmanWorker.phar');
// }

// /*
//  * Setup the phar
//  */
// $p = new Phar('GearmanWorker.phar', 0, 'GearmanWorker.phar');
// $p->compressFiles(Phar::GZ);
// $p->setSignatureAlgorithm(Phar::SHA1);

// /*
//  * Now build the array of files to be in the phar.
//  * The first file is the stub file. The rest of the files are built from the directory.
//  */
// $files = array();
// $files['scripts/GearmanWorker.php'] = $root . '/scripts/GearmanWorker.php';
// $rd = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
// foreach ($rd as $file) {
// 	if ($file->getFilename() != '..' && $file->getFilename() != '.') {
// 		$f = $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
// 		$files[str_replace($root, '', $f)] = $f;
// 	}
// }

// /*
//  * Now build the archive.
//  */
// $p->startBuffering();
// $p->buildFromIterator(new ArrayIterator($files));
// $p->stopBuffering();

// /*
//  * finish up.
//  */
// $p->setStub($p->createDefaultStub('scripts/GearmanWorker.php'));
// // $p = null;

// chmod('GearmanWorker.phar', 0755);
