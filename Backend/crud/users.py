from fastapi import HTTPException, status
from sqlalchemy.orm import Session
from models.typer_user import TyperUser
from models.user import User
from schemas.users import UserCreate
from utils.auth import hash_password


def create_user(db: Session, user: UserCreate):

    existing_user = db.query(User).filter(
        User.username == user.username).first()
    if existing_user:
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST,
            detail="Username already exists"
        )
    typer_user = db.query(TyperUser).filter(
        TyperUser.id == user.typer_user_id).first()
    if not typer_user:
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST,
            detail="Invalid typer_user_id"
        )
    hashed_password = hash_password(user.password)

    db_user = User(
        username=user.username,
        password=hashed_password,
        email=user.email,
        typer_user_id=user.typer_user_id
    )

    db.add(db_user)
    try:
        db.commit()
        db.refresh(db_user)
        return db_user
    except Exception as e:
        db.rollback()
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail="Failed to create user"
        )
