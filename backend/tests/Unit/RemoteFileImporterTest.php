<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\Services\Wordbase\RemoteFileImporter;

class RemoteFileImporterTest extends TestCase
{
    use RefreshDatabase;

    public function test_reads_file_and_inserts_words_with_keys()
    {
        $tempFile = tmpfile();
        $meta = stream_get_meta_data($tempFile);
        $filePath = $meta['uri'];

        fwrite($tempFile, "1\naabe\n18karaadine\naaaaaaaa\naabitsaraamat\nAadam\naadellikult\n--ana-gramm\n\n");
        fflush($tempFile);

        $importer = new RemoteFileImporter("file://$filePath", 3);
        $importer->import();

        fclose($tempFile);

        $this->assertDatabaseHas('words', ['word' => 'aabe', 'key' => 'aabe']);
        $this->assertDatabaseHas('words', ['word' => '18karaadine', 'key' => '18aaadeiknr']);
        $this->assertDatabaseHas('words', ['word' => 'aabitsaraamat', 'key' => 'aaaaaabimrstt']);
        $this->assertDatabaseHas('words', ['word' => 'aadam', 'key' => 'aaadm']);
        $this->assertDatabaseHas('words', ['word' => 'aadellikult', 'key' => 'aadeikllltu']);
        $this->assertDatabaseHas('words', ['word' => 'ana-gramm', 'key' => 'aaagmmnr']);

        $this->assertDatabaseMissing('words', ['word' => 'aaaaaaaa']);
        $this->assertDatabaseMissing('words', ['word' => '1']);
        $this->assertDatabaseCount('words', 6);
    }

}