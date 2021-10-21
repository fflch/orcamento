use PDF;
public function movimento(Movimento $movimento){
    $pdf = PDF::loadView('pdfs.exemplo', [
        'exemplo' => 'Um pdf bacana';
    ]);
    return $pdf->download('exemplo.pdf');
}