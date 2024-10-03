from fastapi import Response
from fastapi import HTTPException, status
from sqlalchemy.orm import Session
from models.typer_user import TyperUser
from models.user import User
from schemas.users import UserCreate, UserUpdate
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


def get_all_users(db: Session):
    return db.query(User).all()


def delete_user(user_id: int, db: Session):
    user = db.query(User).filter(User.id == user_id).first()

    if not user:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="User not found"
        )

    db.delete(user)
    db.commit()
    return Response(status_code=status.HTTP_204_NO_CONTENT)


def update_user(user_id: int, user_data: UserUpdate, db: Session):
    user = db.query(User).filter(User.id == user_id).first()

    if not user:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="User not found"
        )

    if user_data.username:
        existing_user = db.query(User).filter(
            User.username == user_data.username, User.id != user_id).first()
        if existing_user:
            raise HTTPException(
                status_code=status.HTTP_400_BAD_REQUEST,
                detail="Username already exists."
            )
        user.username = user_data.username

    if user_data.email:
        existing_email = db.query(User).filter(
            User.email == user_data.email, User.id != user_id).first()
        if existing_email:
            raise HTTPException(
                status_code=status.HTTP_400_BAD_REQUEST,
                detail="Email already exists."
            )
        user.email = user_data.email

    if user_data.typer_user_id is not None:
        typer_user = db.query(TyperUser).filter(
            TyperUser.id == user_data.typer_user_id).first()
        if not typer_user:
            raise HTTPException(
                status_code=status.HTTP_400_BAD_REQUEST,
                detail=f"typer_user_id {user_data.typer_user_id} does not exist."
            )
        user.typer_user_id = user_data.typer_user_id

    db.commit()
    db.refresh(user)

    return user
