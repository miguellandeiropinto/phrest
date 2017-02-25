<?php

namespace Test\KHerGe\File;

use DateTime;
use KHerGe\File\Exception\PathException;
use PHPUnit_Framework_TestCase as TestCase;

use function KHerGe\File\modified;
use function KHerGe\File\permissions;
use function KHerGe\File\remove;
use function KHerGe\File\resolve;
use function KHerGe\File\temp_dir;
use function KHerGe\File\temp_file;
use function KHerGe\File\temp_path;

/**
 * Verifies that the library functions function (hah!) as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class functionsTest extends TestCase
{
    /**
     * Verify that the last modified Unix timestamp can be retrieved.
     *
     * @covers \KHerGe\File\modified
     */
    public function testGetLastModifiedUnixTimestamp()
    {
        self::assertEquals(
            filemtime(__FILE__),
            modified(__FILE__),
            'The last modified Unix timestamp was not returned.'
        );
    }

    /**
     * Verify that the last modified Unix timestamp can be set.
     *
     * @covers \KHerGe\File\modified
     */
    public function testSetLastModifiedUnixTimestamp()
    {
        $file = tempnam(sys_get_temp_dir(), 'fm-');
        $time = (new DateTime('2016-01-02 03:04:05'))->getTimestamp();

        self::assertEquals(
            $time,
            modified($file, $time),
            'The last modified Unix timestamp was not returned.'
        );

        self::assertEquals(
            $time,
            filemtime($file),
            'The last modified Unix timestamp was not set.'
        );
    }

    /**
     * Verify that an exception is thrown if the path does not exist.
     *
     * @covers \KHerGe\File\modified
     */
    public function testLastModifiedUnixTimestampThrowsExceptionForNonExistentPath()
    {
        $path = '/does/not/exist';

        $this->expectException(PathException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The path "%s" does not exist.',
                $path
            )
        );

        modified($path);
    }

    /**
     * Verify that the Unix permissions can be retrieved.
     *
     * @covers \KHerGe\File\permissions
     */
    public function testGetUnixPermissions()
    {
        self::assertEquals(
            fileperms(__FILE__),
            permissions(__FILE__),
            'The Unix permissions were not returned.'
        );
    }

    /**
     * Verify that the Unix permissions can be set.
     *
     * @covers \KHerGe\File\permissions
     */
    public function testSetUnixPermissions()
    {
        $file = tempnam(sys_get_temp_dir(), 'fm-');
        $permissions = 0777;

        self::assertEquals(
            $permissions,
            permissions(__FILE__, $permissions),
            'The Unix permissions were not returned.'
        );

        self::assertNotEquals(
            $permissions,
            fileperms($file) & $permissions,
            'The Unix permissions were not set.'
        );
    }

    /**
     * Verify that an exception is thrown if the path does not exist.
     *
     * @covers \KHerGe\File\permissions
     */
    public function testUnixPermissionsThrowsExceptionForNonExistentPath()
    {
        $path = '/does/not/exist';

        $this->expectException(PathException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The path "%s" does not exist.',
                $path
            )
        );

        permissions($path);
    }

    /**
     * Verify that the a file path can be removed.
     *
     * @covers \KHerGe\File\remove
     */
    public function testRemoveAFilePath()
    {
        $file = tempnam(sys_get_temp_dir(), 'fm-');

        remove($file);

        self::assertFileNotExists(
            $file,
            'The file path was not removed.'
        );
    }

    /**
     * Verify that remove a non-existent file path throws an exception.
     *
     * @covers \KHerGe\File\remove
     */
    public function testRemovingANonExistentPathThrowsAnException()
    {
        $path = '/this/path/should/not/exist/i/am/sorry/if/it/does';

        $this->expectException(PathException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The path "%s" could not be removed.',
                $path
            )
        );

        @remove($path);
    }

    /**
     * Verify that a directory path can be removed.
     *
     * @covers \KHerGe\File\remove
     */
    public function testRemoveADirectoryPath()
    {
        $dir = tempnam(sys_get_temp_dir(), 'fm-');

        unlink($dir);
        mkdir($dir);
        touch($dir . '/test');

        remove($dir);

        self::assertFileNotExists(
            $dir,
            'The directory was not removed.'
        );
    }

    /**
     * Verify that symlink'd directory contents are not removed.
     *
     * @covers \KHerGe\File\remove
     */
    public function testRemoveADirectoryLinkWithoutDeletingContents()
    {
        $dir = tempnam(sys_get_temp_dir(), 'fm-');

        unlink($dir);
        mkdir($dir);
        touch($dir . '/test');

        $link = tempnam(sys_get_temp_dir(), 'fm-');

        unlink($link);
        symlink($dir, $link);

        remove($link);

        self::assertFileNotExists(
            $link,
            'The directory link was not removed.'
        );

        self::assertFileExists(
            $dir . '/test',
            'The linked directory was deleted too.'
        );
    }

    /**
     * Verify that symlink'd directory contents are also removed.
     *
     * @covers \KHerGe\File\remove
     */
    public function testRemoveADirectoryLinkAndTheLinkedDirectoryContents()
    {
        $dir = tempnam(sys_get_temp_dir(), 'fm-');

        unlink($dir);
        mkdir($dir);
        touch($dir . '/test');

        $link = tempnam(sys_get_temp_dir(), 'fm-');

        unlink($link);
        symlink($dir, $link);

        remove($link, true);

        self::assertFileNotExists(
            $link,
            'The directory link was not removed.'
        );

        self::assertFileNotExists(
            $dir . '/test',
            'The linked directory contents were not deleted.'
        );
    }

    /**
     * Verify that a symbolic link can be resolved.
     *
     * @covers \KHerGe\File\resolve
     */
    public function testResolveASymbolicLink()
    {
        $a = tempnam(sys_get_temp_dir(), 'fm-');
        $b = tempnam(sys_get_temp_dir(), 'fm-');

        unlink($b);
        symlink($a, $b);

        self::assertEquals(
            $a,
            resolve($b),
            'The expected path was not returned for the symbolic link.'
        );

        unlink($a);
        unlink($b);
    }

    /**
     * Verify that resolving a regular path as a symbolic link throws an exception.
     *
     * @covers \KHerGe\File\resolve
     */
    public function testResolvingARegularPathAsASymbolicLinkThrowsAnException()
    {
        $path = '/does/not/exist';

        $this->expectException(PathException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The path "%s" is not a symbolic link.',
                $path
            )
        );

        resolve($path);
    }

    /**
     * Verify that a symbolic link is recursively resolved.
     *
     * @covers \KHerGe\File\resolve
     */
    public function testRecursivelyResolveASymbolicLink()
    {
        $a = tempnam(sys_get_temp_dir(), 'fm-');
        $b = tempnam(sys_get_temp_dir(), 'fm-');
        $c = tempnam(sys_get_temp_dir(), 'fm-');

        unlink($b);
        unlink($c);

        symlink($a, $b);
        symlink($b, $c);

        self::assertEquals(
            $a,
            resolve($c),
            'The symbolic link was not recursively resolved.'
        );

        unlink($a);
        unlink($b);
        unlink($c);
    }

    /**
     * Verify that a new temporary directory is created.
     *
     * @covers \KHerGe\File\temp_dir
     */
    public function testCreateATemporaryDirectory()
    {
        $dir = temp_dir();

        self::assertTrue(
            is_dir($dir),
            'The temporary directory was not created.'
        );

        rmdir($dir);
    }

    /**
     * Verify that a new temporary directory is created using a template.
     *
     * @covers \KHerGe\File\temp_dir
     */
    public function testCreateATemporaryDirectoryUsingATemplate()
    {
        $dir = temp_dir('template-%s');

        self::assertTrue(
            is_dir($dir),
            'The temporary directory was not created.'
        );

        self::assertContains(
            'template-',
            $dir,
            'The directory name did not use the template.'
        );

        rmdir($dir);
    }

    /**
     * Verify that a new temporary file is created.
     *
     * @covers \KHerGe\File\temp_file
     */
    public function testCreateATemporaryFile()
    {
        $file = temp_file();

        self::assertTrue(
            is_file($file),
            'The temporary directory was not created.'
        );

        unlink($file);
    }

    /**
     * Verify that a new temporary file is created using a template.
     *
     * @covers \KHerGe\File\temp_dir
     */
    public function testCreateATemporaryFileUsingATemplate()
    {
        $file = temp_file('template-%s');

        self::assertTrue(
            is_file($file),
            'The temporary file was not created.'
        );

        self::assertContains(
            'template-',
            $file,
            'The file name did not use the template.'
        );

        unlink($file);
    }

    /**
     * Verify that a new temporary path can be generated.
     *
     * @covers \KHerGe\File\temp_path
     */
    public function testGenerateANewTemporaryPath()
    {
        $path = temp_path();

        self::assertStringStartsWith(
            sys_get_temp_dir(),
            $path,
            'The path is not in the temporary directory.'
        );
    }

    /**
     * Verify that a new temporary path can be generated using a template.
     *
     * @covers \KHerGe\File\temp_path
     */
    public function testGenerateANewTemporaryPathUsingATemplate()
    {
        $path = temp_path('template-%s');

        self::assertStringStartsWith(
            sys_get_temp_dir(),
            $path,
            'The path is not in the temporary directory.'
        );

        self::assertContains(
            'template-',
            $path,
            'The path did not use the template.'
        );
    }
}
