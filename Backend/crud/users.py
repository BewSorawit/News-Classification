from sqlalchemy.orm import Session
from models.user import User
from schemas.users import UserCreate, UserUpdate


def create_user(db: Session, user: UserCreate):
    db_user = User(
        username=user.username,
        password=user.password,
        email=user.email,
        typer_user_id=user.typer_user_id
    )

    db.add(db_user)
    db.commit()
    db.refresh(db_user)
    return db_user
