<?php

namespace app\reports;

use Yii;

class Top10PublishedAuthorsReport implements ReportInterface
{
    protected int $year;

    public function setParam(string $name, mixed $value): ReportInterface
    {
        if ($name === 'year' && is_numeric($value)) {
            $this->year = $value;
        }

        return $this;
    }

    public function run(): array
    {
        return Yii::$app->db->createCommand('
            with r as (
                select
                    ba.author_id,
                    COUNT(b.id) as cnt
                from
                    books b
                        inner join books_authors ba on b.id = ba.book_id
                where
                    b.`year` = :year
                group by
                    ba.author_id
            )
            select
                a.name,
                a.patronymic,
                a.surname,
                r.cnt
            from
                r inner join authors a on r.author_id = a.id
            order by r.cnt desc, a.surname, a.name
            limit 10
        ')->bindValue(':year', $this->year)
            ->queryAll();
    }
}
