# AtomicFileSave class

Saves files atomically

Example usage:

    AtomicFileSave::factory()->save('somefile.txt', 'abcabc');

or

    $fileSaver = new AtomicFileSave();
    $fileSaver->save('file.txt', 'datadata', '/tmp');

