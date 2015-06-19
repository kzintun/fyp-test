#!/bin/bash
# ========================================
expeDir=$1
echo "param: $expeDir"


# =====================================

if [[ $# -ne 1 ]];  then
    echo "Illegal number of parameters" 
    exit 1;
fi

# ======================================

if [[ ! -d $1 ]]; then
	echo "the directory does not exist"
	exit 1;
fi

# ========================================
#~ # one rttm for one channel  # output directory is Module1.

for inputFile in $(find $expeDir/1_monophonic/ -iname "*.wav"); do

	outputRoot=$(basename $inputFile .wav)
	outputRoot=$(basename $outputRoot .WAV)
	
	# ============================================
	#~ # there is necessarily a wav file, but optionally a mp4 file
	# ============================================
	
	if [[ -f $expeDir/6_video/$outputRoot.mp4 ]]; then	
		mediaFile=$expeDir/6_video/$outputRoot.mp4		
		echo "videoFile exist $mediaFile"
	elif [[ ! -f $expeDir/6_video/$outputRoot.mp3 ]]; then
		sox $inputFile  $expeDir/6_video/$outputRoot.mp3
		mediaFile=$expeDir/6_video/$outputRoot.mp3
		echo "videoFile exist $mediaFile"
	fi
	
	
	# ============================================
	#~ # finally copy the file if necessary
	# ============================================
	if [[ ! -e ../lectssearchBB/documents/$(basename $mediaFile) ]]; then
		echo  "copying $mediaFile	to ../lectssearchBB/documents/"
		cp $mediaFile	../lectssearchBB/documents/
	fi
	mediaFile=../lectssearchBB/documents/$(basename $mediaFile)
	
	# ============================================
	#~ # preparation of the rttm and xml files for the reference 
	# ============================================
	for ctmFile in $(find $expeDir/3_text/ -name *.ctm); do
		echo "preparing reference"
		if [[ -f $expeDir/3_text/$outputRoot.stm ]]; then
			echo "seg found"
			segmentation=$expeDir/3_text/$outputRoot.stm
			perl ../../Tools/4_formatFiles/ctm_seg2rttm.pl $ctmFile $segmentation			
		else
			echo no segmentation found, next
			break
		fi
		
		rttmFile=$expeDir/3_text/$(basename $ctmFile .ctm).rttm
		xmlFile=../lectssearchBB/documents/$(basename $rttmFile .rttm).xml
		#~ echo $rttmFile
		
		#~  add a description if the file is available
		python ../../Tools/4_formatFiles/fullrttmToXml.py --inputASR $rttmFile --inputAvData $mediaFile --xmlFile $xmlFile
		python generateWordCloudFromXML.py --xmlFile $xmlFile
	done
	
	
	exit
	#~ =========== here ============
	
	# ===============================================
	#~ # preparation of the rttm and xml files for the hypothesis files
	# ===============================================
	for ctmFile in $(find $expeDir/4_output/ -name $outputRoot.*.ctm); do			
		if [[ -f $expeDir/3_text/$outputRoot.stm ]]; then
			segmentation=$expeDir/3_text/$outputRoot.stm
			perl ../../Tools/4_formatFiles/ctm_seg2rttm.pl $ctmFile $segmentation
		elif [[ -f $expeDir/2_segmentation/$segBasemane.rttm ]]; then
			segmentation=$expeDir/3_text/$segBasemane.rttm		
			perl ../../Tools/4_formatFiles/ctm_seg2rttm.pl $ctmFile $segmentation
		else
			echo no segmentation found, next
			break
		fi
		rttmFile=$(basename $ctmFile .ctm).rttm
		python ../../Tools/4_formatFiles/fullrttmToXml.py --inputASR $expeDir/4_output/$rttmFile --inputAvData ../lectssearchBB/documents/$mediaFile --xmlFile ../lectssearchBB/documents/$(basename $rttmFile .rttm).xml
		python generateWordCloudFromXML.py --xmlFile ../lectssearchBB/documents/$(basename $rttmFile .rttm).xml
	done
done

# =========================== #

	
