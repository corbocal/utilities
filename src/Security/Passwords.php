<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Security;

final class Passwords
{
    private const int MAX_LENGTH = 255;
    private const int MIN_LENGTH = 12;
    private const string LOWERCASE = 'abcdefghijklmnopqrstuvwxyz';
    private const string UPPERCASE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private const string NUMBERS = '0123456789';
    private const string SPECIAL = ';!:?-,(){}+.#*%^+&[]@~`|€£$°µ_ø¨§/¿×÷¡ˇ';
    private const string ALL_CHARS = self::LOWERCASE . self::UPPERCASE . self::NUMBERS . self::SPECIAL;

    private const HASH_ALGO = \PASSWORD_DEFAULT;

    private function __construct()
    {
    }

    /**
     * Generates a __PLAIN TEXT__ pseudo-random password of the specified length.
     *
     * @param int $length How long the password will be.
     * * MIN = 12
     * * MAX = 255
     * @param bool $specialCharacters Should the password contain special (non-letter, non-numeric) characters.
     *
     * @return string The plain text password.
     */
    public static function generate(int $length = self::MIN_LENGTH, bool $specialCharacters = false): string
    {
        $length = \min(\max($length, self::MIN_LENGTH), self::MAX_LENGTH);

        $password = '';
        $password .= self::LOWERCASE[\random_int(0, \strlen(self::LOWERCASE) - 1)];
        $password .= self::UPPERCASE[\random_int(0, \strlen(self::UPPERCASE) - 1)];
        $password .= self::NUMBERS[\random_int(0, \strlen(self::NUMBERS) - 1)];
        if ($specialCharacters) {
            $password .= self::SPECIAL[\random_int(0, \strlen(self::SPECIAL) - 1)];
            $chars = self::ALL_CHARS;
        } else {
            $chars = self::LOWERCASE . self::UPPERCASE . self::NUMBERS;
        }

        $remainingLength = $length - \strlen($password);
        for ($i = 0; $i < $remainingLength; $i++) {
            $password .= $chars[\random_int(0, \strlen($chars) - 1)];
        }

        return \str_shuffle($password);
    }

    /**
     * `password_hash()` wrapper.
     *
     * Hashes a plain text password.
     *
     * @param string $plainPassword plain text password.
     * @param string|int $algo hash algorithm.
     * @param array<string,int> $options algorithm options.
     *
     * @throws \InvalidArgumentException if the algorithm is not supported.
     *
     * @return string the hashed password.
     */
    public static function hash(
        #[\SensitiveParameter]
        string $plainPassword,
        string|int $algo = self::HASH_ALGO,
        array $options = []
    ) {
        if (!\in_array($algo, self::algos())) {
            throw new \InvalidArgumentException(
                "The provided algorithm `$algo` is not supported.",
                500
            );
        }

        return \password_hash($plainPassword, $algo, $options);
    }

    /**
     * Returns an hashed pseudo-random password.
     *
     * Wraps the `generate()` and `hash()` functions.
     *
     * @param int $length How long the password will be.
     * * MIN = 12
     * * MAX = 255
     * @param bool $specialCharacters Sets if the password will contain non-alphanumeric characters.
     * @param string|int $algo hash algorithm.
     * @param array<string,int> $options algorithm options.
     *
     * @throws \InvalidArgumentException
     *
     * @return string the hashed password.
     */
    public static function generateHashed(
        int $length = self::MIN_LENGTH,
        bool $specialCharacters = false,
        string|int $algo = self::HASH_ALGO,
        array $options = []
    ): string {
        $password = self::generate($length, $specialCharacters);

        return self::hash($password, $algo, $options);
    }

    /**
     * `password_verify()` wrapper.
     *
     * @param string $plainPassword plain text password.
     * @param string $hashedPassword hashed password.
     *
     * @return bool `true` if the password and hash match, `false` otherwise.
     */
    public static function verify(
        #[\SensitiveParameter]
        string $plainPassword,
        string $hashedPassword
    ): bool {
        return \password_verify(
            $plainPassword,
            $hashedPassword
        );
    }

    /**
     * `password_needs_rehash()` wrapper.
     *
     * @param string $hashedPassword the hashed password to verify.
     * @param string|int $algo the algorithm used for new password hashes.
     * @param array<string,int> $options the options used for new password hashes.
     *
     * @return bool `true` if the password needs to be rehashed, `false` otherwise.
     */
    public static function needsRehash(
        string $hashedPassword,
        string|int $algo = self::HASH_ALGO,
        array $options = []
    ): bool {
        return \password_needs_rehash(
            $hashedPassword,
            $algo,
            $options
        );
    }

    /**
     * `password_get_info()` wrapper
     *
     * @param string $hashedPassword the hashed password to verify.
     *
     * @return array<string,int> the information about the hashed password.
     */
    public static function info(string $hashedPassword): array
    {
        /** @var array<string,int> */
        $result = \password_get_info($hashedPassword);

        return $result;
    }

    /**
     * `password_algos()` wrapper
     *
     * @return array<string> the available password hashing algorithms.
     */
    public static function algos(): array
    {
        /** @var array<string> */
        return \password_algos();
    }
}
