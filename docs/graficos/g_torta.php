<?php
 /*
     Example10 : A 3D exploded pie graph
 */
function Genera_Grafico($cumple, $no_cumple)
{
	 // Standard inclusions   
	 include("pChart/pData.class");
	 include("pChart/pChart.class");
	
	 // Dataset definition 
	 $DataSet = new pData;
	 $DataSet->AddPoint(array($cumple,$no_cumple),"Serie1");
	 $DataSet->AddPoint(array("Cumple","No Cumple"),"Serie2");
	 $DataSet->AddAllSeries();
	 $DataSet->SetAbsciseLabelSerie("Serie2");
	
	 // Initialise the graph
	 $Test = new pChart(420,250);
	 $Test->drawFilledRoundedRectangle(7,7,413,243,5,240,240,240);
	 $Test->drawRoundedRectangle(5,5,415,245,5,230,230,230);
	 $Test->createColorGradientPalette(195,204,56,223,1,1,1);
	
	 // Draw the pie chart
	 $Test->setFontProperties("Fonts/tahoma.ttf",8);
	 $Test->AntialiasQuality = 0;
	 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),180,130,110,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
	 $Test->drawPieLegend(330,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);
	
	 // Write the title
	 $Test->setFontProperties("Fonts/MankSans.ttf",10);
	 $Test->drawTitle(10,20,"Porcentaje de Cumplimiento",100,100,100);
	
	 $Test->Render("Cumplimiento.png");
}
?>