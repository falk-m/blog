<?php

namespace uuid7;

require_once(__DIR__ . '/UnixTimeGenerator.php');

/**
 * This file is based of the ramsey/uuid library.
 */
class UUID7
{
    private static ?UnixTimeGenerator $generator = null;

    public static function randomBytes(): string
    {
        if (self::$generator === null) {
            self::$generator = new UnixTimeGenerator();
        }

        $bytes = self::$generator->generate();

        return self::uuidFromBytesAndVersion($bytes, 7);
    }

    public static function brettyPrint(string $binary)
    {
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($binary), 4));
    }

    /**
     * Returns an RFC 4122 variant Uuid, created from the provided bytes and version
     *
     * @param string $bytes The byte string to convert to a UUID
     * @param int $version The RFC 4122 version to apply to the UUID
     */
    private static function uuidFromBytesAndVersion(string $bytes, int $version)
    {
        /** @var array $unpackedTime */
        $unpackedTime = unpack('n*', substr($bytes, 6, 2));
        $timeHi = (int) $unpackedTime[1];
        $timeHiAndVersion = pack('n*', self::applyVersion($timeHi, $version));

        /** @var array $unpackedClockSeq */
        $unpackedClockSeq = unpack('n*', substr($bytes, 8, 2));
        $clockSeqHi = (int) $unpackedClockSeq[1];
        $clockSeqHiAndReserved = pack('n*', self::applyVariant($clockSeqHi));

        $bytes = substr_replace($bytes, $timeHiAndVersion, 6, 2);
        $bytes = substr_replace($bytes, $clockSeqHiAndReserved, 8, 2);

        return $bytes;
    }


    /**
     * Applies the RFC 4122 version number to the 16-bit `time_hi_and_version` field
     *
     * @link http://tools.ietf.org/html/rfc4122#section-4.1.3 RFC 4122, § 4.1.3: Version
     *
     * @param int $timeHi The value of the 16-bit `time_hi_and_version` field
     *     before the RFC 4122 version is applied
     * @param int $version The RFC 4122 version to apply to the `time_hi` field
     *
     * @return int The 16-bit time_hi field of the timestamp multiplexed with
     *     the UUID version number
     *
     * @psalm-pure
     */
    private static function applyVersion(int $timeHi, int $version): int
    {
        $timeHi = $timeHi & 0x0fff;
        $timeHi |= $version << 12;

        return $timeHi;
    }

    /**
     * Applies the RFC 4122 variant field to the 16-bit clock sequence
     *
     * @link http://tools.ietf.org/html/rfc4122#section-4.1.1 RFC 4122, § 4.1.1: Variant
     *
     * @param int $clockSeq The 16-bit clock sequence value before the RFC 4122
     *     variant is applied
     *
     * @return int The 16-bit clock sequence multiplexed with the UUID variant
     *
     * @psalm-pure
     */
    private static function applyVariant(int $clockSeq): int
    {
        $clockSeq = $clockSeq & 0x3fff;
        $clockSeq |= 0x8000;

        return $clockSeq;
    }
}
