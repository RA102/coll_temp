<?php

namespace common\helpers;

class PersonSocialStatusHelper
{
    #Типы социальных привилегий (таблица person.person_social_privileges)
    const PERSON_SOCIAL_PRIVILEGE = 1; // Привилегии
    // const PERSON_SOCIAL_PRIVILEGE_LIMITED_OPPORTINITIES = 2; // Ограниченные возможности
    const PERSON_SOCIAL_DISABILITIES = 2; // Ограниченные возможности
    // const PERSON_SOCIAL_PRIVILEGE_LIMITED_NEEDS = 3; // Нужды
    const PERSON_SOCIAL_NEEDS = 3; // Нужды
    const PERSON_SOCIAL_FACILITIES = 4; // Льготы

    #типы привилегии
    const SOCIAL_PRIVILEGE_ORPHAN = 1; // Дети - сироты  и оставшиеся без попечения родителей
    const SOCIAL_PRIVILEGE_DISABLED_OF_1_2_GROUPS = 2; // Инвалиды 1-2 групп
    const SOCIAL_PRIVILEGE_CHILDREN_OF_DEAD_IN_AFGHANISTAN = 3; // Дети погибших в Афганистане
    const SOCIAL_PRIVILEGE_TRANSFERRED_WITH_PRIVILEGES = 4; // Уволенные в запас с правом на льготы
    const SOCIAL_PRIVILEGE_CHILDREN_OF_WORKERS_OF_DPLP = 5; // Дети работников отгонного животноводства (Children of workers of distant-pasture livestock production)
    const SOCIAL_PRIVILEGE_RURAL_QUOTA = 6; // По квотам для сельской молодежи и Приаралья
    const SOCIAL_PRIVILEGE_REPATRIATE = 7; // Оралман, репатриант
    const SOCIAL_PRIVILEGE_REFUGEE = 8; // Беженец
    const SOCIAL_PRIVILEGE_DISABLED = 9; // Инвалиды
    const SOCIAL_PRIVILEGE_WARRIORS = 10; //  Лица, приравненные по льготам и гарантиям к участникам войны и инвалидам войны
}