<?php
            $nowUtc = new \DateTime( 'now',  new \DateTimeZone( 'UTC' ) );
            echo '$nowUtc'.PHP_EOL;
            var_dump($nowUtc);
            $nowUtc = new \DateTime( 'now',  new \DateTimeZone( 'UTC' ) );
            echo '$nowUtc->format(\'Y-m-d h:i:s\')'.PHP_EOL;
            var_dump($nowUtc->format('Y-m-d h:i:s'));
            $nowUtc->setTimezone( new \DateTimeZone( 'Europe/Bucharest' ) );
            echo '$nowUtc->setTimezone( new \DateTimeZone( \'Europe/Bucharest\' ) )'.PHP_EOL;
            var_dump($nowUtc);
            echo '$nowUtc->format(\'Y-m-d h:i:s\')'.PHP_EOL;
            var_dump($nowUtc->format('Y-m-d h:i:s'));exit;
?>