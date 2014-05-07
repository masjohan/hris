<?php
/*
 *
 * Copyright 2012 Human Resource Information System
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 *
 * @since 2012
 * @author John Francis Mukulu <john.f.mukulu@gmail.com>
 *
 */
namespace Hris\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    /**
     * Returns users with matching firstname and lastname
     * @param $name
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSearchedUsers($name)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $result = $queryBuilder->select('user')
            ->from('HrisUserBundle:User','user')
            ->where('lower(user.firstName) like :name')
            ->orWhere('lower(user.surname) like :name')
            ->orWhere('lower(user.middleName) like :name')
            ->setParameters(array(
                    'name'=>"%$name%"
                )
            )->getQuery()->getResult();

        return $result;
    }

    /**
     * Returns users within a certain user group
     * @param $name
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsersFromGroup($name)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $result = $queryBuilder->select('user')
            ->from('HrisUserBundle:User','user')
            ->join('user.groups','groups')
            ->where('groups.name like :name')
            ->setParameters(array(
                    'name'=>"%$name%"
                )
            )->getQuery()->getResult();

        return $result;
    }
}
