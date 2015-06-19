#!/bin/bash

perl ctm_seg2rttm.pl ../../Module1/3_YT_Lectures/Lec6MIT16885JAircraftSystemsEngineeringFall2005/4_output/Lec6MIT16885JAircraftSystemsEngineeringFall2005.SYS3.dnn4_pretrain-dbn_dnn.ctm ../../Module1/3_YT_Lectures/Lec6MIT16885JAircraftSystemsEngineeringFall2005/3_text/Lec6MIT16885JAircraftSystemsEngineeringFall2005.stm

python fullrttmToXml.1.0.py --inputASR ../../Module4/lectssearchBB/documents/Lec4MIT16885JAircraftSystemsEngineeringFall2005.SYS3.DBN-DNN.rttm --inputAvData ../../Module4/lectssearchBB/documents/Lec4MIT16885JAircraftSystemsEngineeringFall2005.mp4 --xmlFile ../../Module4/lectssearchBB/documents/Lec4MIT16885JAircraftSystemsEngineeringFall2005.SYS3.DBN-DNN.xml

python generateWordCloudFromXML.py --xmlFile ../lectssearchBB/documents/Lec6MIT16885JAircraftSystemsEngineeringFall2005.SYS3.DBN-DNN.xml 
