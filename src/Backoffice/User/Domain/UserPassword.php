<?php

namespace App\Backoffice\User\Domain;

use InvalidArgumentException;

final class UserPassword
{
    const MINIMUM_LENGTH = 8;
    
    const MAXIMUM_LENGTH = 20;
    
    private $password;
    
    public function __construct( string $aPassword )
    {
        $this->ensureLengthIsBetween8To20Characters( $aPassword );
        
        $this->ensureHasAtLeast1UppercaseCharacter( $aPassword );
        
        $this->ensureHasAtLeast1Number( $aPassword );
        
        $this->password = $aPassword;
    }
    
    private function ensureLengthIsBetween8To20Characters( string $aPassword ): void
    {
        $length = $this->stringLength( $aPassword );
        
        if ( $length < self::MINIMUM_LENGTH ) {
            throw new InvalidArgumentException( sprintf( '%s debe tener entre %s y %s  caracteres.',
                __METHOD__,
                self::MINIMUM_LENGTH,
                self::MAXIMUM_LENGTH ) );
        }
        
        if ( $length > self::MAXIMUM_LENGTH ) {
            throw new InvalidArgumentException( sprintf( '%s debe tener entre %s y %s  caracteres.',
                __METHOD__,
                self::MINIMUM_LENGTH,
                self::MAXIMUM_LENGTH ) );
        }
    }
    
    private function stringLength( $string )
    {
        $encoding = mb_detect_encoding( $string );
        $length = mb_strlen( $string, $encoding );
        
        return $length;
    }
    
    private function ensureHasAtLeast1UppercaseCharacter( string $password )
    {
        if ( 1 !== preg_match( '/[A-Z]+/', $password ) ) {
            throw new InvalidArgumentException( 'La contraseña debe incluir como minimo una letra en mayúscula.' );
        };
    }
    
    private function ensureHasAtLeast1Number( string $password )
    {
        if ( 1 !== preg_match( '/[0-9Z]+/', $password ) ) {
            throw new InvalidArgumentException( 'La contraseña debe incluir como minimo un número.' );
        };
    }
    
    public function __toString()
    {
        return $this->password;
    }
    
    public function value(): string
    {
        return $this->password;
    }
    
}