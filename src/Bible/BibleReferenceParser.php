<?php

namespace AscentCreative\CMS\Bible;

use AscentCreative\CMS\Bible\Exceptions\BibleReferenceParserException;

class BibleReferenceParser {

        private $aryBooks = array();
        private $aryChapters = array();
        
        private $_checkVerseSuffix = false;
        
        function __construct() {
            
            $this->aryBooks[] = array('Genesis', 'Gen', 'genesis', 'Ge', 'Gn');
            $this->aryBooks[] = array('Exodus', 'Ex', 'exodus', 'Exo', 'Exod');
            $this->aryBooks[] = array('Leviticus', 'Lev', 'leviticus', 'Le', 'Lv');
            $this->aryBooks[] = array('Numbers', 'Num', 'numbers', 'Nu', 'Nm', 'Nb');
            $this->aryBooks[] = array('Deuteronomy', 'Deut', 'deuteronomy', 'Dt');
            $this->aryBooks[] = array('Joshua', 'Josh', 'joshua', 'Jos', 'Jsh');
            $this->aryBooks[] = array('Judges', 'Judg', 'judges', 'Jdg', 'Jg', 'Jdgs');
            $this->aryBooks[] = array('Ruth', 'Ruth', 'ruth', 'Rth', 'Ru');
            $this->aryBooks[] = array('1 Samuel', '1 Sam', '1-samuel', '1 Sa', '1Samuel', '1S', 'I Sa', '1 Sm', '1Sa', 'I Sam', '1Sam', 'I Samuel', '1st Samuel', 'First Samuel');
            $this->aryBooks[] = array('2 Samuel', '2 Sam', '2-samuel', '2 Sa', '2S', 'II Sa', '2 Sm', '2Sa', 'II Sam', '2Sam', 'II Samuel', '2Samuel', '2nd Samuel', 'Second Samuel');
            $this->aryBooks[] = array('1 Kings', '1 Kgs', '1-kings', '1 Ki', '1K', 'I Kgs', '1Kgs', 'I Ki', '1Ki', 'I Kings', '1Kings', '1st Kgs', '1st Kings', 'First Kings', 'First Kgs', '1Kin');
            $this->aryBooks[] = array('2 Kings', '2 Kgs', '2-kings', '2 Ki', '2K', 'II Kgs', '2Kgs', 'II Ki', '2Ki', 'II Kings', '2Kings', '2nd Kgs', '2nd Kings', 'Second Kings', 'Second Kgs', '2Kin');
            $this->aryBooks[] = array('1 Chronicles', '1 Chron', '1-chronicles', '1 Ch', 'I Ch', '1Ch', '1 Chr', 'I Chr', '1Chr', 'I Chron', '1Chron', 'I Chronicles', '1Chronicles', '1st Chronicles', 'First Chronicles');
            $this->aryBooks[] = array('2 Chronicles', '2 Chron', '2-chronicles', '2 Ch', 'II Ch', '2Ch', 'II Chr', '2Chr', 'II Chron', '2Chron', 'II Chronicles', '2Chronicles', '2nd Chronicles', 'Second Chronicles'); 
            $this->aryBooks[] = array('Ezra', 'Ezra', 'ezra', 'Ezr');
            $this->aryBooks[] = array('Nehemiah', 'Neh', 'nehemiah', 'Ne');
            $this->aryBooks[] = array('Esther', 'Esth', 'esther', 'Es');
            $this->aryBooks[] = array('Job', 'Job', 'job', 'Jb');
            $this->aryBooks[] = array('Psalm', 'Psalm', 'psalms', 'Pslm', 'Ps', 'Psalms', 'Psa', 'Psm', 'Pss', 'Psalms');
            $this->aryBooks[] = array('Proverbs', 'Prov', 'proverbs', 'Pr', 'Prv');
            $this->aryBooks[] = array('Ecclesiastes', 'Eccles', 'ecclesiastes', 'Ec', 'Qoh', 'Qoheleth');
            $this->aryBooks[] = array('Song of Songs', 'Song', 'song-of-songs', 'So', 'Canticle of Canticles', 'Canticles', 'Song of Solomon', 'SOS');
            $this->aryBooks[] = array('Isaiah', 'Isa', 'isaiah', 'Is');
            $this->aryBooks[] = array('Jeremiah', 'Jer', 'jeremiah', 'Je', 'Jr');
            $this->aryBooks[] = array('Lamentations', 'Lam', 'lamentations', 'La');
            $this->aryBooks[] = array('Ezekiel', 'Ezek', 'ezekiel', 'Eze', 'Ezk');
            $this->aryBooks[] = array('Daniel', 'Dan', 'daniel', 'Da', 'Dn');
            $this->aryBooks[] = array('Hosea', 'Hos', 'hosea', 'Ho');
            $this->aryBooks[] = array('Joel', 'Joel', 'joel', 'Joe', 'Jl');
            $this->aryBooks[] = array('Amos', 'Amos', 'amos', 'Am');
            $this->aryBooks[] = array('Obadiah', 'Obad', 'obadiah', 'Ob');
            $this->aryBooks[] = array('Jonah', 'Jnh', 'jonah', 'Jon');
            $this->aryBooks[] = array('Micah', 'Micah', 'micah', 'Mic');
            $this->aryBooks[] = array('Nahum', 'Nah', 'nahum', 'Na');
            $this->aryBooks[] = array('Habakkuk', 'Hab', 'habakkuk');
            $this->aryBooks[] = array('Zephaniah', 'Zeph', 'zephaniah', 'Zep', 'Zp');
            $this->aryBooks[] = array('Haggai', 'Hag', 'haggai', 'Hg');
            $this->aryBooks[] = array('Zechariah', 'Zech', 'zechariah', 'Zec', 'Zc');
            $this->aryBooks[] = array('Malachi', 'Mal', 'malachi', 'Mal', 'Ml');
    
            // use a site-wide config setting to govern use of DeuterCanonical books...
            //$cfg = Zend_Registry::get('config');
            
            if (false) { //$cfg->biblereferences->includedeuterocanonical == 1) {
                $this->aryBooks[] = array('1 Esdras', '1 Esd', '1-esdras', '1Esd', 'I Esd', '1Es', '1 Es', 'I Es');
                $this->aryBooks[] = array('2 Esdras', '2 Esd', '2-esdras', '2Esd', 'II Esd', '2Es', '2 Es', 'II Es');
                $this->aryBooks[] = array('Tobit', 'Tob', 'tobit', 'Tb');
                $this->aryBooks[] = array('Judith', 'Jth', 'judith', 'Jdt');
                $this->aryBooks[] = array('Wisdom of Solomon', 'Ws', 'wisdom-of-solomon', 'Wisdom', 'Wisd of Sol');
                $this->aryBooks[] = array('Ecclesiasticus', 'Ecclus', 'ecclesiasticus', 'Sirach', 'Sir');
                $this->aryBooks[] = array('Baruch', 'Bar', 'baruch');
                $this->aryBooks[] = array('Letter of Jeremiah', 'Ljr', 'letter-of-jeremiah');
                $this->aryBooks[] = array('Prayer of Azariah', 'Aza', 'prayer-of-azaria');
                $this->aryBooks[] = array('Susanna', 'Sus', 'susanna');
                $this->aryBooks[] = array('Bel and the Dragon', 'Bel', 'bel-and-the-dragon');
                $this->aryBooks[] = array('Prayer of Manasseh', 'Mns', 'prayer-of-manasseh', 'Manasseh', 'Pr of Man', 'Prayer of Manasses');
                $this->aryBooks[] = array('1 Maccabees', '1 Macc', '1-maccabees', '1Macc', 'I Macc', '1 Mc', 'I Mc', '1Mc');
                $this->aryBooks[] = array('2 Maccabees', '2 Macc', '2-maccabees', '2Macc', 'II Macc', '2 Mc', 'II Mc', '2Mc');
                $this->aryBooks[] = array('Song of the Three Holy Children', 'Song Thr',  'song-of-the-three-holy-children', 'Song of Three Children', 'Song of the Three');
            }
            
            $this->aryBooks[] = array('Matthew', 'Matt', 'matthew', 'Mt');
            $this->aryBooks[] = array('Mark', 'Mrk', 'mark', 'Mk', 'Mr');
            $this->aryBooks[] = array('Luke', 'Luke', 'luke', 'Luk', 'Lk');
            $this->aryBooks[] = array('John', 'John', 'john', 'Jn', 'Jhn');
            $this->aryBooks[] = array('Acts', 'Acts', 'acts', 'Ac', 'Acts of the Apostles');
            $this->aryBooks[] = array('Romans', 'Rom', 'romans', 'Ro', 'Rm');
            $this->aryBooks[] = array('1 Corinthians', '1 Cor', '1-corinthians', '1 Co', 'I Co', '1Co', 'I Cor', '1Cor', 'I Corinthians', '1Corinthians', '1st Corinthians', 'First Corinthians');
            $this->aryBooks[] = array('2 Corinthians', '2 Cor', '2-corinthians', '2 Co', 'II Co', '2Co', 'II Cor', '2Cor', 'II Corinthians', '2Corinthians', '2nd Corinthians', 'Second Corinthians');
            $this->aryBooks[] = array('Galatians', 'Gal', 'galatians', 'Ga');
            $this->aryBooks[] = array('Ephesians', 'Eph', 'ephesians', 'Ephes');
            $this->aryBooks[] = array('Philippians', 'Phil', 'philippians', 'Php', 'Phillipians', 'phillipians'); // included a couple of common typos
            $this->aryBooks[] = array('Colossians', 'Col', 'colossians');
            $this->aryBooks[] = array('1 Thessalonians', '1 Thess', '1-thessalonians', '1 Th', 'I Th', '1Th', 'I Thes', '1Thes', 'I Thess', '1Thess', 'I Thessalonians', '1Thessalonians', '1st Thessalonians', 'First Thessalonians');
            $this->aryBooks[] = array('2 Thessalonians', '2 Thess', '2-thessalonians', '2 Th', 'II Th', '2Th', 'II Thes', '2Thes', 'II Thess', '2Thess', 'II Thessalonians', '2Thessalonians', '2nd Thessalonians', 'Second Thessalonians');
            $this->aryBooks[] = array('1 Timothy', '1 Tim', '1-timothy', '1 Ti', 'I Ti', '1Ti', 'I Tim', '1Tim', 'I Timothy', '1Timothy', '1st Timothy', 'First Timothy');
            $this->aryBooks[] = array('2 Timothy', '2 Tim', '2-timothy', '2 Ti', 'II Ti', '2Ti', 'II Tim', '2Tim', 'II Timothy', '2Timothy', '2nd Timothy', 'Second Timothy');
            $this->aryBooks[] = array('Titus', 'Tit', 'titus');
            $this->aryBooks[] = array('Philemon', 'Philem', 'philemon', 'Phm');
            $this->aryBooks[] = array('Hebrews', 'Heb', 'hebrews');
            $this->aryBooks[] = array('James', 'James', 'james', 'Jas', 'Jm');
            $this->aryBooks[] = array('1 Peter', '1 Pet', '1-peter', '1 Pe', 'I Pe', '1Pe', 'I Pet', '1Pet', 'I Pt', '1 Pt', '1Pt', 'I Peter', '1Peter', '1st Peter', 'First Peter');
            $this->aryBooks[] = array('2 Peter', '2 Pet', '2-peter', '2 Pe', 'II Pe', '2Pe', 'II Pet', '2Pet', 'II Pt', '2 Pt', '2Pt', 'II Peter', '2Peter', '2nd Peter', 'Second Peter');
            $this->aryBooks[] = array('1 John', '1 John', '1-john', '1 Jn', 'I Jn', '1Jn', 'I Jo', '1Jo', 'I Joh', '1Joh', 'I Jhn', '1 Jhn', '1Jhn', 'I John', '1John', '1st John', 'First John');
            $this->aryBooks[] = array('2 John', '2 John', '2-john', '2 Jn', 'II Jn', '2Jn', 'II Jo', '2Jo', 'II Joh', '2Joh', 'II Jhn', '2 Jhn', '2Jhn', 'II John', '2John', '2nd John', 'Second John');
            $this->aryBooks[] = array('3 John', '3 John', '3-john', '3 Jn', 'III Jn', '3Jn', 'III Jo', '3Jo', 'III Joh', '3Joh', 'III Jhn', '3 Jhn', '3Jhn', 'III John', '3John', '3rd John', 'Third John');
            $this->aryBooks[] = array('Jude', 'Jude', 'jude', 'Jud');
            $this->aryBooks[] = array('Revelation', 'Rev', 'revelation', 'Re', 'The Revelation');
            
            
            $aryChaptersOT = array(50, 40, 27, 36, 34, 24, 21, 4, 31, 24, 22, 25, 29, 36, 10, 13, 10, 42, 150, 31, 12, 8, 66, 52, 5, 48, 12, 14, 3, 9, 1, 4, 7, 3, 3, 3, 2, 14, 4);
            $aryChaptersDC = array(9, 16, 14, 16, 19, 51, 5, 1, 1, 1, 1, 1, 16, 15, 1);
            $aryChaptersNT = array(28, 16, 24, 21, 28, 16, 16, 13, 6, 6, 4, 4, 5, 3, 6, 4, 3, 1, 13, 5, 5, 3, 5, 1, 1, 1, 22);
            
            if (false) { //$cfg->biblereferences->includedeuterocanonical == 1) {
                $this->aryChapters = array_merge($aryChaptersOT, $aryChaptersDC, $aryChaptersNT);
            } else {
                $this->aryChapters = array_merge($aryChaptersOT, $aryChaptersNT);
            }
            
            if (true) { //$cfg->biblereferences->checkVerseSuffix) {
               $this->_checkVerseSuffix = true;
            }
            
            //$this->aryChapters = array(50, 40, 27, 36, 34, 24, 21, 4, 31, 24, 22, 25, 29, 36, 10, 13, 10, 42, 150, 31, 12, 8, 66, 52, 5, 48, 12, 14, 3, 9, 1, 4, 7, 3, 3, 3, 2, 14, 4, 28, 16, 24, 21, 28, 16, 16, 13, 6, 6, 4, 4, 5, 3, 6, 4, 3, 1, 13, 5, 5, 3, 5, 1, 1, 1, 22);
            
        }
        
        function makeBibleRefFromArray($ary, $abbrev=true, $incBook=true, $incChap=true) {
            
            $bookName = $this->aryBooks[$ary['book']][$abbrev?1:0];
            
            if ($bookName == "Psalms" && $ary['startChapter']) {
                $bookName = "Psalm";
            }
            
            //$out = $bookName . ' ' . $sc;
            $out = ($incBook?($this->aryBooks[$ary['book']][$abbrev?1:0] . ' '):'') . ($incChap && ($ary['startChapter']>0)?$ary['startChapter']:'');
            
            if ($ary['startVerse'] > 0) {
                //$out .= ":" . $sv;
                $out .= ($incChap?":":'') . $ary['startVerse'] . (isset($ary['startVerseSuffix'])?$ary['startVerseSuffix']:'');
            }
            
            if ($ary['endChapter'] > $ary['startChapter']) {
                $out .= '-' . $ary['endChapter'] . ':' . $ary['endVerse'];
            } else {
                if ($ary['endVerse'] > $ary['startVerse'] && $ary['endVerse'] != 999) {
                    $out .= '-' . $ary['endVerse'];
                }
            }
            
            $out .= (isset($ary['endVerseSuffix'])?$ary['endVerseSuffix']:'');
            
            return trim($out);
            
        }
        
        function makeBibleRef($bk, $sc, $sv, $ec, $ev, $abbrev=true, $incBook=true, $incChap=true, $svs='', $evs='') {
        
            $bookName = $this->aryBooks[$bk][$abbrev?1:0];
            
            if ($bookName == "Psalms" && $sc) {
                $bookName = "Psalm";
            }
            
            //$out = $bookName . ' ' . $sc;
            $out = ($incBook?($this->aryBooks[$bk][$abbrev?1:0] . ' '):'') . ($incChap && $sc > 0?$sc:'');
            
            if ($sv > 0) {
                //$out .= ":" . $sv;
                $out .= ($incChap?":":'') . $sv . $svs;
            }
            
            if ($ec > $sc) {
                $out .= '-' . $ec . ':' . $ev;	
            } else {
                if ($ev > $sv && $ev != 999) {
                    $out .= '-' . $ev;
                }
            }
            
            $out .= $evs;
            
            return trim($out);
        
        }
        
        
        function getBookNumber($bkName) {
        
            $i = 0;
            $match = false;
            $bk = -1;

            while (!$match && $i < sizeOf($this->aryBooks)) {

               $match = array_search(
                            strtolower($bkName), 
                            array_map('strtolower', $this->aryBooks[$i])
                        ) !== false;

                $i++;

            }

           
        
            if ($match) {
                $bk = $i-1;
            } 
            return $bk;
        
        }
        
        function getBookName($i) {
        
            $ary = $this->getBookFullNames();
            return $ary[$i];
        
        }
        
        function getBookAbbrevName($i) {
        
            $ary = $this->getBookAbbrevNames();
            return $ary[$i];
        
        }
        
        function getBookUrlkey($i) {
        
            $ary = $this->getBookUrlkeys();
            return $ary[$i];
        
        }
        
        function getBookFullNameByUrlkey($key) {
            
            $num = $this->getBookNumber($key);
            return $this->getBookName($num);
            
        }
        
        
    
        function parseBibleRef($ref) {	

            $ref = str_replace("vv", ":", $ref);
            $ref = str_replace("v", ":", $ref);
            

            $ref = str_replace(": ", ":", $ref);
            $ref = str_replace(" :", ":", $ref);
            $ref = str_replace("- ", "-", $ref);
            $ref = str_replace(" -", "-", $ref);

            
        
            $parsed = array();
        
            $split = explode(" ", $ref);
        
            $nums = array_pop($split);
        
            $bkName = join(" ", $split);
            
            $bookonly = false;
            
            if (strlen($bkName) == 1 || $bkName == '') {
                $bkName = $ref;
                $bookonly = true;
            }
            
            //echo '<P>Book: ' . $bkName . '</P>';
            
            $bk = $this->getBookNumber($bkName);
        
            //echo '<P>Book Num: ' . $bk . '</P>';

            if ($bk == -1) {
                throw new BibleReferenceParserException('Book "' . $bkName . '" not recognised');
            }
            
            if (!$bookonly && $bk != -1) {
                $split = explode("-", $nums);
        
                $start = explode(":", $split[0]);
                $end = null;
                if(isset($split[1])) {
                    $end = explode(":", $split[1]);
                }
                
                $sc = $start[0];
                $sv = null;
                if(isset($start[1])){
                    $sv = $start[1];
                }
                
        
                if (!$sv) {
                    $sv = 0;
                }
        
                $ev = null;
                if (isset($end[1])) {
                    $ev = $end[1];
                }

                if (is_null($ev)) {
                    if (isset($end[0])) {
                        $ev = $end[0];
                    } else {
                        if ($sv == 0) {
                            $ev = 999;
                        } else {
                            $ev = $sv;
                        }
                        //$ev = 0;
                    }
                    $ec = $sc;
                } else {
        
                    $ec = $end[0];
        
                    if (!$ec) {
                        $ec = 0;
                    }
                }
            
            } else {
                
                $sc = $sv = $ec = $ev = 0;
                
            }
            
        
            
            $parsed['book'] = $bk;
            $parsed['startChapter'] = $sc;
            $parsed['startVerse'] = $sv;
            $parsed['endChapter'] = $ec;
            $parsed['endVerse'] = $ev;
            
            
            
            if ($this->_checkVerseSuffix) {
                
                $svlast = substr($sv,-1);
                if (!is_numeric($svlast)) {
                    $parsed['startVerse'] = substr($sv,0,-1);
                    $parsed['startVerseSuffix'] = $svlast;
                }
                
                $evlast = substr($ev,-1);
                if (!is_numeric($evlast)) {
                    $parsed['endVerse'] = substr($ev,0,-1);
                    $parsed['endVerseSuffix'] = $evlast;
                }
                
            }
            
            // also return a standardised version of the reference:
            $parsed['ref'] = $this->makeBibleRefFromArray($parsed, false);


        //	print_r($parsed);
        //	exit();   
            
            return $parsed;
        
        }	
    
        function getBooks() {
            return $this->aryBooks;	
        }
        
        function getBookFullNames() {
            $aryOut = array();
            foreach($this->aryBooks as $id=>$names) {
                    $aryOut[$id] = $names[0];
            }
            return $aryOut;
        }
        
        function getBookAbbrevNames() {
            $aryOut = array();
            foreach($this->aryBooks as $id=>$names) {
                    $aryOut[$id] = $names[1];
            }
            return $aryOut;
        }
        
        function getBookUrlkeys() {
            $aryOut = array();
            foreach($this->aryBooks as $id=>$names) {
                $aryOut[$id] = $names[2];
            }
            return $aryOut;
        }
        
        
        function getBookFullAndAbbrevNames() {
            $aryOut = array();
            foreach($this->aryBooks as $id=>$names) {
                    $aryOut[$names[1]] = $names[0];
            }
            return $aryOut;
        }
        
        function getChapterCount($book) { 
            if(!is_numeric($book)) {
                $num = $this->getBookNumber($book);
            } else {
                $num = $book;
            }
            return $this->aryChapters[$num];
        }
    
    
    }
    

