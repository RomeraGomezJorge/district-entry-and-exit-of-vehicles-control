<?php
declare( strict_types = 1 );

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\Exception;

use App\Shared\Domain\DomainError;

final class DistrictEntryAndExitOfVehiclesControlNotExist extends DomainError
{
    private string $id;
    
    public function __construct( string $id )
    {
        $this->id = $id;
        
        parent::__construct();
    }
    
    public function errorCode(): string
    {
        return ' district_entry_and_exit_of_vehicles_control_not_exist';
    }
    
    protected function errorMessage(): string
    {
        return sprintf( 'El registro de ingreso con el id "%s" no existe!', $this->id );
    }
    
}