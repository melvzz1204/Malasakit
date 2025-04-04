<?php

namespace Admin\Malasakit\Models;

use Illuminate\Database\Eloquent\Model;

class MedInventory extends Model
{
    protected $table = 'med_inventory';
    public $timestamps = false; // Disable timestamps if not needed

    protected $fillable = [
        'Drug_Code',
        'Drug_Name',
        'Specification_Model',
        'Production_Batch',
        'Period_Validity',
        'Manufacturer',
        'Quantity',
        'Unit_Price',
        'Amount',
        'Remarks',
    ];
}
