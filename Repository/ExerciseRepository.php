<?php

/**
 * ExoOnLine
 * Copyright or © or Copr. Université Jean Monnet (France), 2012
 * dsi.dev@univ-st-etienne.fr
 *
 * This software is a computer program whose purpose is to [describe
 * functionalities and technical features of your software].
 *
 * This software is governed by the CeCILL license under French law and
 * abiding by the rules of distribution of free software.  You can  use,
 * modify and/ or redistribute the software under the terms of the CeCILL
 * license as circulated by CEA, CNRS and INRIA at the following URL
 * "http://www.cecill.info".
 *
 * As a counterpart to the access to the source code and  rights to copy,
 * modify and redistribute granted by the license, users are provided only
 * with a limited warranty  and the software's author,  the holder of the
 * economic rights,  and the successive licensors  have only  limited
 * liability.
 *
 * In this respect, the user's attention is drawn to the risks associated
 * with loading,  using,  modifying and/or developing or reproducing the
 * software by the user in light of its specific status of free software,
 * that may mean  that it is complicated to manipulate,  and  that  also
 * therefore means  that it is reserved for developers  and  experienced
 * professionals having in-depth computer knowledge. Users are therefore
 * encouraged to load and test the software's suitability as regards their
 * requirements in conditions enabling the security of their systems and/or
 * data to be ensured and,  more generally, to use and operate it in the
 * same conditions as regards security.
 *
 * The fact that you are presently reading this means that you have had
 * knowledge of the CeCILL license and that you accept its terms.
*/

namespace UJM\ExoBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ExerciseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExerciseRepository extends EntityRepository
{
    public function getExerciseMarks($exoId, $order = '')
    {
        if ($order != '') {
            $orderBy = ' ORDER BY '.$order;
        }
        $dql = 'SELECT sum(r.mark) as noteExo, p.id as paper
            FROM UJM\ExoBundle\Entity\Response r JOIN r.paper p JOIN p.exercise e
            WHERE e.id='.$exoId.' AND p.interupt=0 group by p.id'.$orderBy;

        $query = $this->_em->createQuery($dql);

        return $query->getResult();
    }

    public function getExerciceByUser($userID)
    {
        $dql = 'SELECT e.id, e.title
            FROM UJM\ExoBundle\Entity\Subscription s JOIN s.exercise e
            WHERE s.user='.$userID.' AND s.creator = 1';

        $query = $this->_em->createQuery($dql);

        return $query->getResult();
    }
    
    public function getExerciseAdmin($userID)
    {
        $exercises = array();
        
        $dql = 'SELECT w.id
            FROM Claroline\CoreBundle\Entity\User u 
            JOIN u.roles r 
            JOIN r.workspace w
            WHERE u.id='.$userID.' AND r.translationKey=\'manager\'' ;

        $query = $this->_em->createQuery($dql);
        
        foreach ($query->getResult() as $ws) {
            $dql = 'SELECT e.id, e.title
                    FROM UJM\ExoBundle\Entity\Exercise e
                    JOIN e.resourceNode rn
                    JOIN rn.resourceType rt
                    JOIN rn.workspace w
                    WHERE rt.name =\'ujm_exercise\'
                    AND w.id='.$ws['id'].'
                    ORDER BY e.title';
            $queryResources = $this->_em->createQuery($dql);
            foreach ($queryResources->getResult() as $resource) {
                $exercises[] =  $resource;
            }
        }
        
        return $exercises;
        
    }
}