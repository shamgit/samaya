<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PayslipMail extends Mailable
{
    public $payroll;
    public $employeeName;
    public $pdf;

    public function __construct($payroll, $employeeName, $pdf)
    {
        $this->payroll = $payroll;
        $this->employeeName = $employeeName;
        $this->pdf = $pdf;
    }

    public function build()
    {
      $subject = 'Payslip - ' . $this->payroll->pay_period_start_date;
        return $this->subject($subject)
            ->view('emails.payslip')
            ->with([
                'payroll' => $this->payroll,
                'employeeName' => $this->employeeName,
            ])
            ->attachData(
                $this->pdf,
                'Payslip.pdf',
                [
                    'mime' => 'application/pdf',
                ]
            );
    }
}